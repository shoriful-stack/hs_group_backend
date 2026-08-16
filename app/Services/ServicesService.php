<?php

namespace App\Services;

use App\CustomClass\Helper;
use App\Models\Service;
use App\Models\ServiceHighlight;
use App\Models\ServiceBenefit;
use App\Models\ServiceCapability;
use App\Models\ServiceScope;
use App\Models\ServiceProcess;
use App\Models\ServiceEquipment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;

class ServicesService
{
    public function createOrUpdate($request, $id = null)
    {
        try {
            DB::beginTransaction();

            $service = $id
                ? Service::lockForUpdate()->findOrFail($id)
                : new Service();
                
            if ($request->hasFile('image')) {
                $image = Helper::imageUpload(
                    $request->file('image'),
                    uniqid(),
                    'service',
                    $service->image
                );
                $service->image = $image;
            }

            $service->category_id = $request->category_id;
            $service->title = $request->title;
            $service->subtitle = $request->subtitle;
            $service->description = $request->description;

            $service->seo_title = $request->seo_title;
            $service->seo_keywords = $request->seo_keywords;
            $service->seo_description = $request->seo_description;

            $service->save();

            if ($id) {
                $service->highlights()->delete();
                $service->benefits()->delete();
                $service->scopes()->delete();
                $service->capabilities()->delete();
                $service->processSteps()->delete();
                $service->equipments()->delete();
            }

            if ($request->highlights_title) {

                foreach ($request->highlights_title as $key => $title) {

                    if (!$title) continue;

                    ServiceHighlight::create([
                        'service_id' => $service->id,
                        'title' => $title,
                        'value' => $request->highlights_value[$key] ?? null,
                    ]);
                }
            }
            if ($request->benefits_title) {

                foreach ($request->benefits_title as $key => $title) {

                    if (!$title) continue;

                    ServiceBenefit::create([
                        'service_id' => $service->id,
                        'icon' => $request->benefits_icon[$key] ?? null,
                        'title' => $title,
                        'description' => $request->benefits_description[$key] ?? null,
                    ]);
                }
            }

            if ($request->scope_title) {

                foreach ($request->scope_title as $key => $title) {

                    if (!$title) continue;

                    ServiceScope::create([
                        'service_id' => $service->id,
                        'step_number' => $request->scope_step[$key] ?? ($key + 1),
                        'title' => $title,
                        'description' => $request->scope_description[$key] ?? null,
                    ]);
                }
            }
            if ($request->capabilities_title) {

                foreach ($request->capabilities_title as $key => $title) {

                    if (!$title) continue;

                    ServiceCapability::create([
                        'service_id' => $service->id,
                        'title' => $title,
                        'description' => $request->capabilities_value[$key] ?? null,
                    ]);
                }
            }

            if ($request->process_title) {

                foreach ($request->process_title as $key => $title) {

                    if (!$title) continue;

                    ServiceProcess::create([
                        'service_id' => $service->id,
                        'serial_no' => $request->process_serial[$key] ?? ($key + 1),
                        'title' => $title,
                        'description' => $request->process_description[$key] ?? null,
                    ]);
                }
            }

            if ($request->service_equipment_category_id) {

                foreach ($request->service_equipment_category_id as $key => $category) {

                    if (!$category) continue;

                    $items = explode(',', $request->equipment_items[$key] ?? '');

                    foreach ($items as $item) {

                        $item = trim($item);

                        if (!$item) continue;

                        ServiceEquipment::create([
                            'service_id' => $service->id,
                            'service_equipment_category_id' => $category,
                            'name' => $item,
                        ]);
                    }
                }
            }

            DB::commit();

            return [
                'success' => true,
                'message' => $id
                    ? 'Service updated successfully.'
                    : 'Service created successfully.'
            ];
        } catch (QueryException $e) {

            DB::rollBack();
            Log::error('DB Error in ServicesService: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Database error occurred while processing the service.'
            ];
        } catch (\Exception $e) {

            DB::rollBack();
            Log::error('Error in ServicesService: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}
