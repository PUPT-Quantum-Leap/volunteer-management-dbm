<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mobile Kitchen Operations Chart - Editor</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f0f4f8;
            padding: 20px;
        }

        .page-container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #1e40af;
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo {
            width: 80px;
            height: 80px;
            background: #1e40af;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 18px;
        }

        .title {
            font-size: 24px;
            font-weight: bold;
            color: #1e40af;
        }

        .header-info {
            text-align: right;
        }

        .info-box {
            background: #1e40af;
            color: white;
            padding: 10px 20px;
            margin-bottom: 5px;
            border-radius: 4px;
        }

        .info-label {
            font-size: 12px;
            font-weight: bold;
        }

        .info-value {
            font-size: 14px;
        }

        .org-box {
            border: 2px solid #1e40af;
            padding: 12px 20px;
            margin: 10px auto;
            text-align: center;
            background: white;
            position: relative;
        }

        .org-box.filled {
            background: #e0e7ff;
        }

        .org-box-title {
            font-size: 11px;
            font-weight: bold;
            color: #1e40af;
            margin-bottom: 4px;
        }

        .org-box-name {
            font-size: 13px;
            color: #1f2937;
        }

        .connector {
            width: 2px;
            background: #1e40af;
            margin: 0 auto;
            height: 20px;
        }

        .horizontal-connector {
            height: 2px;
            background: #1e40af;
            width: 100%;
        }

        .flex-container {
            display: flex;
            gap: 20px;
            margin: 20px 0;
        }

        .flex-item {
            flex: 1;
        }

        .side-box {
            border: 2px solid #1e40af;
            padding: 15px;
            background: #f8fafc;
            margin-bottom: 15px;
        }

        .side-box-title {
            font-size: 12px;
            font-weight: bold;
            color: #1e40af;
            margin-bottom: 8px;
            text-align: center;
            text-transform: uppercase;
        }

        .side-box-content {
            font-size: 11px;
            color: #1f2937;
            line-height: 1.6;
        }

        .team-box {
            border: 2px solid #1e40af;
            padding: 12px;
            margin-bottom: 10px;
            background: white;
        }

        .team-name {
            font-size: 11px;
            font-weight: bold;
            color: #1e40af;
            margin-bottom: 4px;
        }

        .team-location {
            font-size: 10px;
            color: #6b7280;
            font-style: italic;
            margin-bottom: 6px;
        }

        .team-members {
            font-size: 11px;
            color: #1f2937;
            line-height: 1.5;
        }

        .grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin: 20px 0;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin: 20px 0;
        }

        .bottom-section {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 15px;
            margin-top: 30px;
        }

        .info-panel {
            border: 2px solid #d97706;
            padding: 15px;
            background: #fef3c7;
        }

        .info-panel-title {
            font-size: 12px;
            font-weight: bold;
            color: #92400e;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        .info-panel-content {
            font-size: 11px;
            color: #1f2937;
            line-height: 1.6;
        }

        .vehicle-assignment {
            border: 2px solid #1e40af;
            padding: 15px;
            background: #f8fafc;
        }

        .vehicle-list {
            font-size: 11px;
            color: #1f2937;
            line-height: 1.8;
        }

        sup {
            font-size: 8px;
        }

        .four-box-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin: 15px 0;
        }

        .coordinator-box {
            border: 2px solid #1e40af;
            padding: 10px;
            background: #dbeafe;
            text-align: center;
        }

        /* Editor Styles */
        .editor-toolbar {
            background: #1e40af;
            color: white;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .editor-toolbar h3 {
            margin: 0;
            font-size: 18px;
        }

        .toolbar-buttons {
            display: flex;
            gap: 10px;
        }

        .btn-editor {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s;
        }

        .btn-editor:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-1px);
        }

        .btn-editor.active {
            background: #10b981;
            border-color: #10b981;
        }

        .btn-editor.danger {
            background: #ef4444;
            border-color: #ef4444;
        }

        .btn-editor.danger:hover {
            background: #dc2626;
        }

        /* Draggable Elements */
        .draggable {
            cursor: move;
            transition: all 0.2s;
        }

        .draggable:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .draggable.dragging {
            opacity: 0.5;
            transform: rotate(5deg);
        }

        .drop-zone {
            border: 2px dashed #1e40af;
            padding: 20px;
            margin: 10px 0;
            border-radius: 8px;
            background: rgba(30, 64, 175, 0.05);
            transition: all 0.3s;
        }

        .drop-zone.drag-over {
            background: rgba(30, 64, 175, 0.1);
            border-color: #10b981;
        }

        .drop-zone.empty {
            color: #6b7280;
            text-align: center;
        }

        /* Editable Elements */
        .editable {
            position: relative;
        }

        .editable:hover .edit-icon {
            opacity: 1;
        }

        .edit-icon {
            position: absolute;
            top: 5px;
            right: 5px;
            background: #1e40af;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            cursor: pointer;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .edit-input {
            width: 100%;
            padding: 8px;
            border: 1px solid #1e40af;
            border-radius: 4px;
            font-size: 13px;
            margin-top: 5px;
        }

        /* Volunteer Pool */
        .volunteer-pool {
            background: #f8fafc;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .pool-title {
            font-size: 14px;
            font-weight: bold;
            color: #1e40af;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .volunteer-item {
            display: inline-block;
            background: white;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            padding: 6px 12px;
            margin: 2px;
            font-size: 12px;
            cursor: move;
            transition: all 0.2s;
        }

        .volunteer-item:hover {
            background: #dbeafe;
            border-color: #1e40af;
        }

        .volunteer-item.dragging {
            opacity: 0.5;
        }

        /* Modal for editing */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 8px;
            padding: 20px;
            max-width: 500px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e5e7eb;
        }

        .modal-title {
            font-size: 18px;
            font-weight: bold;
            color: #1e40af;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: #6b7280;
        }

        .close-btn:hover {
            color: #1e40af;
        }

        /* Status indicators */
        .status-indicator {
            position: absolute;
            top: 5px;
            left: 5px;
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }

        .status-filled {
            background: #10b981;
        }

        .status-empty {
            background: #f59e0b;
        }

        .status-error {
            background: #ef4444;
        }

        /* Print styles */
        @media print {
            .editor-toolbar,
            .edit-icon,
            .btn-editor,
            .volunteer-pool {
                display: none !important;
            }

            .org-box,
            .side-box,
            .team-box {
                break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="page-container">
        <!-- Header -->
        <div class="header">
            <div class="logo-section">
                <div class="logo">NLCOM</div>
                <div class="title">MOBILE KITCHEN OPERATIONS</div>
            </div>
            <div class="header-info">
                <div class="info-box">
                    <span class="info-label">DATE:</span> 
                    <span class="info-value">{{ $orgChart->date ?? 'November 22, 2025' }}</span>
                </div>
                <div class="info-box">
                    <span class="info-label">OBJECTIVE:</span> 
                    <span class="info-value">{{ $orgChart->objective ?? '2400' }}</span>
                </div>
                <div class="info-box">
                    <span class="info-label">MENU:</span> 
                    <span class="info-value">{{ $orgChart->menu ?? 'Champorado' }}</span>
                </div>
                <div class="info-box">
                    <span class="info-label">VOLUNTEERS:</span> 
                    <span class="info-value">{{ $orgChart->volunteers_count ?? '46' }}</span>
                </div>
            </div>
        </div>

        <!-- Responsible Official -->
        <div class="org-box filled editable" style="width: 300px;" data-role="leader">
            <div class="status-indicator status-filled"></div>
            <div class="edit-icon" onclick="editPosition('leader')"><i class="fas fa-pencil-alt"></i></div>
            <div class="org-box-title">RESPONSIBLE OFFICIAL</div>
            <div class="org-box-name" id="leader-name">{{ $orgChart->leader_name ?? 'Paul Glague' }}</div>
        </div>

        <div class="connector"></div>

        <!-- Incident Commander -->
        <div class="org-box filled" style="width: 300px;">
            <div class="org-box-title">INCIDENT COMMANDER</div>
            <div class="org-box-name">{{ $orgChart->deputy_leader ?? 'Catherine Tolentino' }}</div>
        </div>

        <div class="connector"></div>

        <!-- Four Coordinators Grid -->
        <div class="four-box-grid" style="width: 600px; margin: 10px auto;">
            <div class="coordinator-box editable" data-role="planning-coordinator">
                <div class="status-indicator status-filled"></div>
                <div class="edit-icon" onclick="editPosition('planning-coordinator')"><i class="fas fa-pencil-alt"></i></div>
                <div class="org-box-title">PLANNING:</div>
                <div class="org-box-name" id="planning-coordinator-name">{{ $orgChart->planning_team_lead ?? 'Heidi Glague' }}</div>
            </div>
            <div class="coordinator-box editable" data-role="purchasing-coordinator">
                <div class="status-indicator status-filled"></div>
                <div class="edit-icon" onclick="editPosition('purchasing-coordinator')"><i class="fas fa-pencil-alt"></i></div>
                <div class="org-box-title">PURCHASING:</div>
                <div class="org-box-name" id="purchasing-coordinator-name">{{ $orgChart->purchasing_team_lead ?? 'Stephanie Tan' }}</div>
            </div>
            <div class="coordinator-box editable" data-role="operations-coordinator">
                <div class="status-indicator status-filled"></div>
                <div class="edit-icon" onclick="editPosition('operations-coordinator')"><i class="fas fa-pencil-alt"></i></div>
                <div class="org-box-title">MWC COORDINATOR:</div>
                <div class="org-box-name" id="operations-coordinator-name">{{ $orgChart->operations_team_lead ?? 'Kevin Tabares' }}</div>
            </div>
            <div class="coordinator-box editable" data-role="communications-coordinator">
                <div class="status-indicator status-filled"></div>
                <div class="edit-icon" onclick="editPosition('communications-coordinator')"><i class="fas fa-pencil-alt"></i></div>
                <div class="org-box-title">SAFETY & EMERGENCY:</div>
                <div class="org-box-name" id="communications-coordinator-name">{{ $orgChart->communications_team_lead ?? 'Sam Obmerga' }}</div>
            </div>
        </div>

        <div class="connector"></div>

        <!-- Main Three Columns -->
        <div class="flex-container">
            <!-- Left Column: Mobile Kitchen -->
            <div class="flex-item">
                <div class="org-box filled">
                    <div class="org-box-title">MOBILE KITCHEN</div>
                    <div class="org-box-name" style="font-style: italic;">{{ $mobileKitchen->coordinator ?? 'Elisa Aquino' }}<sup>^</sup></div>
                </div>
                <div class="connector"></div>

                <div class="side-box">
                    <div class="side-box-title">KITCHEN TRUCK</div>
                    <div class="side-box-content">
                        @if(isset($mobileKitchen->kitchen_truck))
                            {{ $mobileKitchen->kitchen_truck }}
                        @else
                            Miah, Jones, Sam Rice, Blessing
                        @endif
                    </div>
                </div>

                <div class="side-box drop-zone" data-role="food-prep" ondrop="dropVolunteer(event)" ondragover="allowDrop(event)" ondragleave="dragLeave(event)">
                    <div class="side-box-title">FOOD PREP</div>
                    <div class="side-box-content" id="food-prep-content">
                        @if(isset($mobileKitchen->food_prep))
                            {{ $mobileKitchen->food_prep }}
                        @else
                            Teresa<sup>^</sup>, Cath<sup>^</sup>, Natasya, Michay, Aly, Evenmae
                        @endif
                    </div>
                </div>

                <div class="side-box drop-zone" data-role="volunteer-care" ondrop="dropVolunteer(event)" ondragover="allowDrop(event)" ondragleave="dragLeave(event)">
                    <div class="side-box-title">VOLUNTEER CARE</div>
                    <div class="side-box-content" id="volunteer-care-content">
                        @if(isset($mobileKitchen->volunteer_care))
                            {{ $mobileKitchen->volunteer_care }}
                        @else
                            Myrrh<sup>^</sup>, Rhia<sup>^</sup>, Lady
                        @endif
                    </div>
                </div>

                <div class="side-box drop-zone" data-role="wash-cleanup" ondrop="dropVolunteer(event)" ondragover="allowDrop(event)" ondragleave="dragLeave(event)">
                    <div class="side-box-title">WASH / CLEAN UP</div>
                    <div class="side-box-content" id="wash-cleanup-content">
                        @if(isset($mobileKitchen->wash_cleanup))
                            {{ $mobileKitchen->wash_cleanup }}
                        @else
                            Orly<sup>^</sup>, John, Daniel, Ariel
                        @endif
                    </div>
                </div>

                <div class="side-box drop-zone" data-role="inventory" ondrop="dropVolunteer(event)" ondragover="allowDrop(event)" ondragleave="dragLeave(event)">
                    <div class="side-box-title">INVENTORY</div>
                    <div class="side-box-content" id="inventory-content">
                        @if(isset($mobileKitchen->inventory))
                            {{ $mobileKitchen->inventory }}
                        @else
                            Beth<sup>^</sup>, Nestor, Johan (pm)
                        @endif
                    </div>
                </div>
            </div>

            <!-- Middle Column: AM Distribution -->
            <div class="flex-item">
                <div class="org-box filled">
                    <div class="org-box-title">AM DISTRIBUTION</div>
                    <div class="org-box-name" style="font-style: italic;">{{ $amDistribution->coordinator ?? 'Steph Tan' }}</div>
                </div>
                <div class="connector"></div>

                @if(isset($amTeams))
                    @foreach($amTeams as $team)
                        <div class="team-box">
                            <div class="team-name">TEAM {{ $team->name }}</div>
                            <div class="team-location">({{ $team->location }})</div>
                            <div class="team-members">{{ $team->members }}</div>
                        </div>
                    @endforeach
                @else
                    <div class="team-box">
                        <div class="team-name">TEAM ALPHA</div>
                        <div class="team-location">(VITAS/CALAMBA/ANNEX)</div>
                        <div class="team-members">Kevin<sup>~</sup></div>
                    </div>

                    <div class="team-box">
                        <div class="team-name">TEAM BRAVO</div>
                        <div class="team-location">(DAN/NIBIN)</div>
                        <div class="team-members">John<sup>~</sup>, Blessing, Natasya, Jhoy2, Evenmae</div>
                    </div>

                    <div class="team-box">
                        <div class="team-name">TEAM CHARLIE1</div>
                        <div class="team-location">(MASVILLE)</div>
                        <div class="team-members">Sam<sup>~</sup>, Michay<sup>^</sup>, Aly</div>
                    </div>

                    <div class="team-box">
                        <div class="team-name">TEAM CHARLIE2</div>
                        <div class="team-location">(BAÑAL)</div>
                        <div class="team-members">Orly<sup>~</sup>, Daniel, Rhia</div>
                    </div>
                @endif
            </div>

            <!-- Right Column: PM Distribution -->
            <div class="flex-item">
                <div class="org-box filled">
                    <div class="org-box-title">PM DISTRIBUTION</div>
                    <div class="org-box-name" style="font-style: italic;">{{ $pmDistribution->coordinator ?? 'Steph Tan' }}</div>
                </div>
                <div class="connector"></div>

                @if(isset($pmTeams))
                    @foreach($pmTeams as $team)
                        <div class="team-box">
                            <div class="team-name">TEAM {{ $team->name }}</div>
                            <div class="team-location">({{ $team->location }})</div>
                            <div class="team-members">{{ $team->members }}</div>
                        </div>
                    @endforeach
                @else
                    <div class="team-box">
                        <div class="team-name">TEAM DELTA1</div>
                        <div class="team-location">(amor)</div>
                        <div class="team-members">Cedie<sup>~</sup>, Lady<sup>^</sup></div>
                    </div>

                    <div class="team-box">
                        <div class="team-name">TEAM DELTA2</div>
                        <div class="team-location">(BUCATIL)</div>
                        <div class="team-members">Michael S<sup>~</sup>, Karl, Aly</div>
                    </div>

                    <div class="team-box">
                        <div class="team-name">TEAM ECHO</div>
                        <div class="team-location">(DELMAR)</div>
                        <div class="team-members">John<sup>~</sup>, Cath<sup>^</sup>, Johan</div>
                    </div>

                    <div class="team-box">
                        <div class="team-name">TEAM FOXTROT</div>
                        <div class="team-location">(PAM/SUN)</div>
                        <div class="team-members">&nbsp;</div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Bottom Section -->
        <div class="bottom-section">
            <div class="info-panel">
                <div class="info-panel-title">SYMBOLS</div>
                <div class="info-panel-content">
                    * new volunteer<br>
                    ~ driver<br>
                    ^/^ team leader
                </div>
            </div>

            <div class="info-panel">
                <div class="info-panel-title">MEAL BREAKDOWN</div>
                <div class="info-panel-content">
                    @if(isset($mealBreakdown))
                        {{ $mealBreakdown }}
                    @else
                        Breakfast - 40<br>
                        Lunch - 50<br>
                        Snacks - 50
                    @endif
                </div>
            </div>

            <div class="vehicle-assignment">
                <div class="info-panel-title" style="color: #1e40af;">VEHICLE ASSIGNMENT</div>
                <div class="vehicle-list">
                    @if(isset($vehicles))
                        {!! nl2br(e($vehicles)) !!}
                    @else
                        Alpha - Flexi<br>
                        Bravo - Hilux<br>
                        Charlie 1 - Clipper<br>
                        Charlie 2 - Chevy<br>
                        Delta 1 - Hilux<br>
                        Delta 2 - Black<br>
                        Echo - Chevy<br>
                        Foxtrot - Flexi/Clipper
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
</html>
