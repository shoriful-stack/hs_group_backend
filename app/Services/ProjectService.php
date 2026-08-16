<?php

namespace App\Services;

use App\CustomClass\Helper;
use App\Models\Project;
use App\Models\ProjectEquipment;
use App\Models\ProjectGallery;
use App\Models\ProjectHighlight;
use App\Models\ProjectImpact;
use App\Models\ProjectInformation;
use App\Models\ProjectProblemSolving;
use App\Models\ProjectReview;
use App\Models\ProjectScope;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;

class ProjectService
{
    public function createOrUpdate($request, $id = null)
    {
        try {
            DB::beginTransaction();

            $project = $id
                ? Project::lockForUpdate()->findOrFail($id)
                : new Project();

            if ($request->hasFile('image')) {
                $image = Helper::imageUpload(
                    $request->file('image'),
                    uniqid(),
                    'project',
                    $project->image
                );
                $project->image = $image;
            }

            $project->category_id = $request->category_id;
            $project->our_customer_id = $request->customer_id;
            $project->location = $request->location;
            $project->year = $request->year;
            $project->duration = $request->duration;
            $project->project_value = $request->project_value;
            $project->title = $request->title;
            $project->description = $request->description;

            $project->seo_title = $request->seo_title;
            $project->seo_keywords = $request->seo_keywords;
            $project->seo_description = $request->seo_description;

            $project->save();

            if ($id) {
                $project->highlights()->delete();
                $project->informations()->delete();
                $project->scopes()->delete();
                $project->problemsolvings()->delete();
                $project->equipments()->delete();
                $project->impacts()->delete();
                $project->reviews()->delete();
                $project->ctas()->delete();
            }

            if ($request->highlights_title) {

                foreach ($request->highlights_title as $key => $title) {

                    if (!$title) continue;

                    ProjectHighlight::create([
                        'project_id' => $project->id,
                        'title' => $title,
                        'value' => $request->highlights_value[$key] ?? null,
                    ]);
                }
            }
            if ($request->informations_title) {

                foreach ($request->informations_title as $key => $title) {

                    if (!$title) continue;

                    ProjectInformation::create([
                        'project_id' => $project->id,
                        'icon' => $request->informations_icon[$key] ?? null,
                        'title' => $title,
                        'description' => $request->informations_description[$key] ?? null,
                    ]);
                }
            }

            if ($request->scope_title) {

                foreach ($request->scope_title as $key => $title) {

                    if (!$title) continue;

                    ProjectScope::create([
                        'project_id' => $project->id,
                        'step_number' => $request->scope_step[$key] ?? ($key + 1),
                        'title' => $title,
                        'description' => $request->scope_description[$key] ?? null,
                    ]);
                }
            }
            // if ($request->type) {

            //     foreach ($request->type as $key => $ty) {

            //         // Allow "0" (challenge) to be saved, but skip empty/undefined values.
            //         if ($ty === null || $ty === '') continue;

            //         ProjectProblemSolving::create([
            //             'project_id' => $project->id,
            //             'type' => $ty,
            //             'description' => $request->challenge_description[$key] ?? null,
            //         ]);
            //     }
            // }
            if ($request->challenge) {

                foreach ($request->challenge as $key => $ch) {

                    if (!$ch) continue;

                    ProjectProblemSolving::create([
                        'project_id' => $project->id,
                        'challenge' => $ch,
                        'solution' => $request->solution[$key] ?? null,
                    ]);
                }
            }

            // gallery images delete (if any marked for deletion)
            if ($request->has('delete_images')) {
                foreach ($request->delete_images as $galleryId) {
                    $gallery = ProjectGallery::where('id', $galleryId)
                        ->where('project_id', $project->id)
                        ->first();
                    if ($gallery) {
                        if (file_exists(public_path($gallery->image))) {
                            unlink(public_path($gallery->image));
                        }

                        $gallery->delete();
                    }
                }
            }

            if ($request->hasFile('project_images')) {
                foreach ($request->file('project_images') as $key => $imageFile) {

                    if (!$imageFile) continue;

                    $uploadedPath = Helper::imageUpload(
                        $imageFile,
                        uniqid(),
                        'project_gallery',
                    );

                    ProjectGallery::create([
                        'project_id' => $project->id,
                        'image' => $uploadedPath,
                    ]);
                }
            }

            if ($request->project_equipment_category_id) {

                foreach ($request->project_equipment_category_id as $key => $category) {

                    if (!$category) continue;

                    $items = explode(',', $request->equipment_items[$key] ?? '');
                    $icons = explode(',', $request->equipment_icons[$key] ?? '');

                    foreach ($items as $index => $item) {

                        $item = trim($item);

                        if (!$item) continue;

                        $icon = isset($icons[$index]) ? trim($icons[$index]) : null;

                        ProjectEquipment::create([
                            'project_id' => $project->id,
                            'project_equipment_category_id' => $category,
                            'name' => $item,
                            'icon' => $icon
                        ]);
                    }
                }
            }

            if ($request->impacts_title) {

                foreach ($request->impacts_title as $key => $title) {

                    if (!$title) continue;

                    ProjectImpact::create([
                        'project_id' => $project->id,
                        'title' => $title,
                        'value' => $request->impacts_value[$key] ?? null,
                    ]);
                }
            }

            if ($request->reviews_department) {

                foreach ($request->reviews_department as $key => $department) {

                    if (!$department) continue;

                    ProjectReview::create([
                        'project_id' => $project->id,
                        'department' => $department,
                        'designation' => $request->reviews_designation[$key] ?? null,
                        'description' => $request->reviews_description[$key] ?? null,
                    ]);
                }
            }

            if ($request->question) {
                $project->ctas()->create([
                    'question' => $request->question,
                    'answer' => $request->answer
                ]);
            }

            DB::commit();

            return [
                'success' => true,
                'message' => $id
                    ? 'Project updated successfully.'
                    : 'Project created successfully.'
            ];
        } catch (QueryException $e) {

            DB::rollBack();
            Log::error('DB Error in ProjectService: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Database error occurred while processing the project.'
            ];
        } catch (\Exception $e) {

            DB::rollBack();
            Log::error('Error in ProjectService: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}
