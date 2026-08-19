<?php

namespace Database\Seeders;

use App\Models\Capability;
use App\Models\Industry;
use App\Models\Sustainability;
use Illuminate\Database\Seeder;

class AboutPageSeeder extends Seeder
{
    public function run(): void
    {
        $capabilities = [
            ['title' => 'Engineering Design', 'icon' => 'PenTool', 'content' => 'Comprehensive engineering planning and technical design solutions.', 'features' => 'Structural Design, Electrical Design, Civil Design, Mechanical Design', 'serial_no' => 1],
            ['title' => 'Procurement', 'icon' => 'Package', 'content' => 'Strategic sourcing and procurement of high-quality engineering materials and equipment.', 'features' => 'Vendor Selection, Material Sourcing, Equipment Supply, Quality Assurance', 'serial_no' => 2],
            ['title' => 'Project Management', 'icon' => 'Workflow', 'content' => 'Professional planning, execution, monitoring, and delivery of engineering projects.', 'features' => 'Planning, Scheduling, Cost Control, Risk Management', 'serial_no' => 3],
            ['title' => 'Construction & Installation', 'icon' => 'HardHat', 'content' => 'Civil construction, equipment installation, infrastructure deployment, and site execution.', 'features' => 'Site Execution, Equipment Install, Civil Works, Infrastructure Deploy', 'serial_no' => 4],
            ['title' => 'Testing & Commissioning', 'icon' => 'ClipboardCheck', 'content' => 'Quality assurance, testing, inspection, commissioning, and system validation.', 'features' => 'QA/QC Testing, Inspection, System Validation, Handover', 'serial_no' => 5],
            ['title' => 'Operations & Maintenance', 'icon' => 'Settings', 'content' => 'Long-term preventive maintenance, inspections, asset optimization, and technical support.', 'features' => 'Preventive Maintenance, Corrective Maintenance, Asset Management, Remote Support', 'serial_no' => 6],
            ['title' => 'Digital Monitoring', 'icon' => 'Monitor', 'content' => 'IoT monitoring, smart dashboards, analytics, remote supervision, and intelligent reporting.', 'features' => 'IoT Platforms, Smart Dashboards, Remote Supervision, Analytics', 'serial_no' => 7],
        ];

        foreach ($capabilities as $row) {
            Capability::query()->updateOrCreate(['title' => $row['title']], $row);
        }

        $industries = [
            ['title' => 'Power', 'content' => 'Substations, transmission, and utility systems.', 'icon' => 'Zap', 'serial_no' => 1],
            ['title' => 'Telecom', 'content' => 'Towers, BTS, fiber, and network infrastructure.', 'icon' => 'Radio', 'serial_no' => 2],
            ['title' => 'Oil & Gas', 'content' => 'Industrial electrical and facility support works.', 'icon' => 'Fuel', 'serial_no' => 3],
            ['title' => 'Infrastructure', 'content' => 'Civil corridors, lighting, and public works.', 'icon' => 'Building2', 'serial_no' => 4],
            ['title' => 'Renewable Energy', 'content' => 'Solar generation and grid interconnection.', 'icon' => 'Sun', 'serial_no' => 5],
            ['title' => 'Industrial Automation', 'content' => 'Controls, SCADA, and plant modernization.', 'icon' => 'Cpu', 'serial_no' => 6],
            ['title' => 'Government', 'content' => 'Public-sector engineering and national programs.', 'icon' => 'Landmark', 'serial_no' => 7],
            ['title' => 'Smart City', 'content' => 'IoT, digital monitoring, and urban systems.', 'icon' => 'Network', 'serial_no' => 8],
        ];

        foreach ($industries as $row) {
            Industry::query()->updateOrCreate(['title' => $row['title']], $row);
        }

        Sustainability::query()->updateOrCreate(
            ['id' => Sustainability::query()->value('id') ?? 1],
            [
                'title'     => 'Engineering for a Sustainable Future',
                'subtitle'  => 'HS Group integrates sustainable engineering practices, responsible resource management, workplace safety, renewable energy, and community development into every project we deliver.',
                'sub_title' => 'Engineering Solutions That Respect People and the Planet',
                'content'   => 'HS Group believes that sustainable engineering is essential for long-term progress. Every project is planned with a focus on safety, environmental responsibility, energy efficiency, innovation, and operational excellence to create lasting value for industries and communities.',
                'quote'     => 'Every engineering decision we make today creates the infrastructure that future generations will depend upon.',
                'closing'   => 'That responsibility drives everything we build.',
            ]
        );
    }
}
