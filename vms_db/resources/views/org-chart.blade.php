<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer Assignment</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #ffffff;
            padding: 20px;
            color: #1e293b;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(24, 119, 242, 0.3);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #1877F2 0%, #42A5F5 100%);
            padding: 30px;
            text-align: center;
            color: white;
        }

        .header h1 {
            font-size: 32px;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .header p {
            font-size: 16px;
            opacity: 0.95;
        }

        .content {
            padding: 30px;
        }

        .controls-section {
            background: #f8f8f8;
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 30px;
            border-left: 4px solid #1877F2;
        }

        .controls-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            font-size: 14px;
        }

        input[type="date"],
        input[type="number"],
        select {
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.3s;
            background: white;
        }

        input[type="date"]:focus,
        input[type="number"]:focus,
        select:focus {
            outline: none;
            border-color: #1877F2;
            box-shadow: 0 0 0 3px rgba(24, 119, 242, 0.1);
        }

        .btn-container {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }

        button {
            padding: 14px 32px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .btn-generate {
            background: #1877F2;
            color: white;
        }

        .btn-generate:hover {
            background: #1565C0;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(24, 119, 242, 0.4);
        }

        .btn-regenerate {
            background: #333;
            color: white;
        }

        .btn-regenerate:hover {
            background: #1a1a1a;
            transform: translateY(-2px);
        }

        .btn-save {
            background: white;
            color: #1877F2;
            border: 2px solid #1877F2;
        }

        .btn-save:hover {
            background: #1877F2;
            color: white;
        }

        .loading {
            text-align: center;
            padding: 40px;
            display: none;
        }

        .loading.active {
            display: block;
        }

        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #1877F2;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .assignments-container {
            display: none;
            margin-top: 30px;
        }

        .assignments-container.active {
            display: block;
        }

        .assignment-header {
            background: #333;
            color: white;
            padding: 20px;
            border-radius: 8px 8px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .assignment-date {
            font-size: 18px;
            font-weight: 600;
        }

        .volunteer-count {
            background: #1877F2;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
        }

        .assignments-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            padding: 30px;
            background: #f8f8f8;
            border-radius: 0 0 8px 8px;
        }

        .assignment-column {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .assignment-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            border-left: 4px solid #1877F2;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: all 0.3s;
        }

        .assignment-card:hover {
            transform: translateX(5px);
            box-shadow: 0 4px 12px rgba(24, 119, 242, 0.2);
        }

        .card-title {
            font-weight: 700;
            color: #333;
            margin-bottom: 12px;
            font-size: 15px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .card-subtitle {
            font-size: 13px;
            color: #666;
            margin-bottom: 10px;
            font-style: italic;
        }

        .member-list {
            list-style: none;
        }

        .member-item {
            padding: 8px 12px;
            margin-bottom: 6px;
            background: #f8f8f8;
            border-radius: 4px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.2s;
        }

        .member-item:hover {
            background: #fff3e6;
        }

        .member-name {
            color: #333;
            font-weight: 500;
        }

        .member-skill {
            font-size: 11px;
            background: #1877F2;
            color: white;
            padding: 3px 8px;
            border-radius: 10px;
        }

        .coordinator-badge {
            background: #333;
            color: white;
            padding: 6px 12px;
            border-radius: 4px;
            font-weight: 600;
            display: inline-block;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 6px;
            margin-bottom: 20px;
            display: none;
        }

        .alert.active {
            display: block;
        }

        .alert-warning {
            background: #e3f2fd;
            border-left: 4px solid #1877F2;
            color: #0d47a1;
        }

        .alert-info {
            background: #d1ecf1;
            border-left: 4px solid #0c5460;
            color: #0c5460;
        }

        @media (max-width: 1024px) {
            .assignments-grid {
                grid-template-columns: 1fr;
            }
        }

        @media print {
            body {
                background: white;
            }
            .controls-section, .btn-container {
                display: none;
            }
            .container {
                box-shadow: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Volunteer Assignment</h1>
            <p>Automated Team Assignment System</p>
        </div>

        <div class="content">
            <div class="controls-section">
                <div class="controls-grid">
                    <div class="form-group">
                        <label for="operation_date">Operation Date</label>
                        <input type="date" id="operation_date" required>
                    </div>
                    <div class="form-group">
                        <label for="objective">Objective (Meals Target)</label>
                        <input type="number" id="objective" placeholder="e.g., 2400" value="2400">
                    </div>
                    <div class="form-group">
                        <label for="menu">Menu</label>
                        <select id="menu">
                            <option value="Champorado">Champorado</option>
                            <option value="Arroz Caldo">Arroz Caldo</option>
                            <option value="Lugaw">Lugaw</option>
                            <option value="Pancit">Pancit</option>
                            <option value="Custom">Custom</option>
                        </select>
                    </div>
                </div>

                <div class="btn-container">
                    <button class="btn-generate" onclick="generateAssignments()">
                         Generate Assignments
                    </button>
                    <button class="btn-regenerate" onclick="regenerateAssignments()" style="display:none;" id="regenerateBtn">
                         Regenerate
                    </button>
                    <button class="btn-save" onclick="saveAssignments()" style="display:none;" id="saveBtn">
                        Save & Export
                    </button>
                </div>
            </div>

            <div id="alert" class="alert"></div>

            <div class="loading" id="loading">
                <div class="spinner"></div>
                <p style="color: #666; font-size: 16px;">Analyzing volunteer availability and skills...</p>
            </div>

            <div class="assignments-container" id="assignmentsContainer">
                <div class="assignment-header">
                    <div class="assignment-date" id="displayDate"></div>
                    <div class="volunteer-count" id="volunteerCount"></div>
                </div>

                <div class="assignments-grid">
                    <!-- Mobile Kitchen Column -->
                    <div class="assignment-column">
                        <div class="assignment-card">
                            <div class="card-title">Mobile Kitchen</div>
                            <div class="card-subtitle">Coordinator</div>
                            <div class="coordinator-badge" id="mk_coordinator">Loading...</div>
                        </div>

                        <div class="assignment-card">
                            <div class="card-title">Kitchen Truck</div>
                            <ul class="member-list" id="kitchen_truck"></ul>
                        </div>

                        <div class="assignment-card">
                            <div class="card-title">Food Prep</div>
                            <ul class="member-list" id="food_prep"></ul>
                        </div>

                        <div class="assignment-card">
                            <div class="card-title">Volunteer Care</div>
                            <ul class="member-list" id="volunteer_care"></ul>
                        </div>

                        <div class="assignment-card">
                            <div class="card-title">Wash / Clean Up</div>
                            <ul class="member-list" id="wash_cleanup"></ul>
                        </div>

                        <div class="assignment-card">
                            <div class="card-title">Inventory</div>
                            <ul class="member-list" id="inventory"></ul>
                        </div>
                    </div>

                    <!-- AM Distribution Column -->
                    <div class="assignment-column">
                        <div class="assignment-card">
                            <div class="card-title">AM Distribution</div>
                            <div class="card-subtitle">Coordinator</div>
                            <div class="coordinator-badge" id="am_coordinator">Loading...</div>
                        </div>

                        <div class="assignment-card">
                            <div class="card-title">Team Alpha</div>
                            <div class="card-subtitle">HIFAD/ANNEX</div>
                            <ul class="member-list" id="team_alpha"></ul>
                        </div>

                        <div class="assignment-card">
                            <div class="card-title">Team Bravo</div>
                            <div class="card-subtitle">NAH/NBIN</div>
                            <ul class="member-list" id="team_bravo"></ul>
                        </div>

                        <div class="assignment-card">
                            <div class="card-title">Team Charlie 1</div>
                            <div class="card-subtitle">MASVLLE</div>
                            <ul class="member-list" id="team_charlie1"></ul>
                        </div>

                        <div class="assignment-card">
                            <div class="card-title">Team Charlie 2</div>
                            <div class="card-subtitle">BANAN</div>
                            <ul class="member-list" id="team_charlie2"></ul>
                        </div>
                    </div>

                    <!-- PM Distribution Column -->
                    <div class="assignment-column">
                        <div class="assignment-card">
                            <div class="card-title">PM Distribution</div>
                            <div class="card-subtitle">Coordinator</div>
                            <div class="coordinator-badge" id="pm_coordinator">Loading...</div>
                        </div>

                        <div class="assignment-card">
                            <div class="card-title">Team Delta 1</div>
                            <div class="card-subtitle">BRGP</div>
                            <ul class="member-list" id="team_delta1"></ul>
                        </div>

                        <div class="assignment-card">
                            <div class="card-title">Team Delta 2</div>
                            <div class="card-subtitle">EUCATIN</div>
                            <ul class="member-list" id="team_delta2"></ul>
                        </div>

                        <div class="assignment-card">
                            <div class="card-title">Team Echo</div>
                            <div class="card-subtitle">DELPAN</div>
                            <ul class="member-list" id="team_echo"></ul>
                        </div>

                        <div class="assignment-card">
                            <div class="card-title">Team Foxtrot</div>
                            <div class="card-subtitle">PAM/SUN</div>
                            <ul class="member-list" id="team_foxtrot"></ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // This would connect to your Laravel backend
        async function generateAssignments() {
            const date = document.getElementById('operation_date').value;
            const objective = document.getElementById('objective').value;
            const menu = document.getElementById('menu').value;

            if (!date) {
                showAlert('Please select an operation date', 'warning');
                return;
            }

            // Show loading
            document.getElementById('loading').classList.add('active');
            document.getElementById('assignmentsContainer').classList.remove('active');

            try {
                // In Laravel, this would call your API endpoint
                const response = await fetch('/api/assignments/generate', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                    },
                    body: JSON.stringify({
                        date: date,
                        objective: objective,
                        menu: menu
                    })
                });

                // Simulate API delay for demo
                await new Promise(resolve => setTimeout(resolve, 1500));

                // Mock data - Replace with actual API response
                const assignments = getMockAssignments();
                
                displayAssignments(assignments, date);
                
                document.getElementById('regenerateBtn').style.display = 'inline-block';
                document.getElementById('saveBtn').style.display = 'inline-block';
                
            } catch (error) {
                showAlert('Error generating assignments. Please try again.', 'warning');
                console.error(error);
            } finally {
                document.getElementById('loading').classList.remove('active');
            }
        }

        function displayAssignments(data, date) {
            // Store assignments globally for saving
            window.assignments = data;

            // Update header
            document.getElementById('displayDate').textContent = new Date(date).toLocaleDateString('en-US', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
            document.getElementById('volunteerCount').textContent = `${data.totalVolunteers} Volunteers`;

            // Mobile Kitchen
            document.getElementById('mk_coordinator').textContent = data.mobile_kitchen.coordinator;
            displayTeamMembers('kitchen_truck', data.mobile_kitchen.kitchen_truck);
            displayTeamMembers('food_prep', data.mobile_kitchen.food_prep);
            displayTeamMembers('volunteer_care', data.mobile_kitchen.volunteer_care);
            displayTeamMembers('wash_cleanup', data.mobile_kitchen.wash_cleanup);
            displayTeamMembers('inventory', data.mobile_kitchen.inventory);

            // AM Distribution
            document.getElementById('am_coordinator').textContent = data.am_distribution.coordinator;
            displayTeamMembers('team_alpha', data.am_distribution.team_alpha);
            displayTeamMembers('team_bravo', data.am_distribution.team_bravo);
            displayTeamMembers('team_charlie1', data.am_distribution.team_charlie1);
            displayTeamMembers('team_charlie2', data.am_distribution.team_charlie2);

            // PM Distribution
            document.getElementById('pm_coordinator').textContent = data.pm_distribution.coordinator;
            displayTeamMembers('team_delta1', data.pm_distribution.team_delta1);
            displayTeamMembers('team_delta2', data.pm_distribution.team_delta2);
            displayTeamMembers('team_echo', data.pm_distribution.team_echo);
            displayTeamMembers('team_foxtrot', data.pm_distribution.team_foxtrot);

            document.getElementById('assignmentsContainer').classList.add('active');

            showAlert('✅ Assignments generated successfully based on skills and availability!', 'info');
        }

        function displayTeamMembers(elementId, members) {
            const element = document.getElementById(elementId);
            element.innerHTML = members.map(member => `
                <li class="member-item">
                    <span class="member-name">${member.name}</span>
                    <span class="member-skill">${member.skill}</span>
                </li>
            `).join('');
        }

        function regenerateAssignments() {
            if (confirm('This will generate a new set of assignments. Continue?')) {
                generateAssignments();
            }
        }

        async function saveAssignments() {
            const date = document.getElementById('operation_date').value;
            const objective = document.getElementById('objective').value;
            const menu = document.getElementById('menu').value;

            try {
                // Save to database and update Org Chart
                const response = await fetch('/api/assignments/save', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                    },
                    body: JSON.stringify({
                        date: date,
                        objective: objective,
                        menu: menu,
                        assignments: window.assignments // Store assignments globally after generation
                    })
                });

                if (!response.ok) {
                    throw new Error('Failed to save assignments');
                }

                const result = await response.json();
                showAlert(result.message || '✅ Assignments saved successfully and updated in Org Chart!', 'info');

                // Optional: Generate PDF or print
                setTimeout(() => {
                    if (confirm('Would you like to print the assignments?')) {
                        window.print();
                    }
                }, 500);

            } catch (error) {
                showAlert('Error saving assignments. Please try again.', 'warning');
                console.error(error);
            }
        }

        function showAlert(message, type) {
            const alert = document.getElementById('alert');
            alert.textContent = message;
            alert.className = `alert alert-${type} active`;
            
            setTimeout(() => {
                alert.classList.remove('active');
            }, 5000);
        }

        // Mock data generator - Replace with actual Laravel API
        function getMockAssignments() {
            return {
                totalVolunteers: 46,
                mobile_kitchen: {
                    coordinator: 'Elisa Aquino',
                    kitchen_truck: [
                        { name: 'Miah Santos', skill: 'Driver' },
                        { name: 'Jones Miller', skill: 'Cook' },
                        { name: 'Sam Rice', skill: 'Cook' }
                    ],
                    food_prep: [
                        { name: 'Teresa Cruz', skill: 'Prep' },
                        { name: 'Cath Rodriguez', skill: 'Prep' },
                        { name: 'Natasya Lee', skill: 'Prep' }
                    ],
                    volunteer_care: [
                        { name: 'Myrrh Garcia', skill: 'Care' },
                        { name: 'Rhia Torres', skill: 'Care' }
                    ],
                    wash_cleanup: [
                        { name: 'Orly Ramos', skill: 'Cleanup' },
                        { name: 'John Dela Cruz', skill: 'Cleanup' },
                        { name: 'Daniel Reyes', skill: 'Cleanup' }
                    ],
                    inventory: [
                        { name: 'Beth Mendoza', skill: 'Logistics' },
                        { name: 'Nestor Gomez', skill: 'Logistics' }
                    ]
                },
                am_distribution: {
                    coordinator: 'Steph Tan',
                    team_alpha: [
                        { name: 'Kevin Lee', skill: 'Leader' }
                    ],
                    team_bravo: [
                        { name: 'John Cruz', skill: 'Driver' },
                        { name: 'Blessing Okafor', skill: 'Dist' }
                    ],
                    team_charlie1: [
                        { name: 'Sam Rivera', skill: 'Leader' },
                        { name: 'Michay Santos', skill: 'Dist' }
                    ],
                    team_charlie2: [
                        { name: 'Orly Bautista', skill: 'Driver' },
                        { name: 'Daniel Kim', skill: 'Dist' }
                    ]
                },
                pm_distribution: {
                    coordinator: 'Steph Tan',
                    team_delta1: [
                        { name: 'Cedie Flores', skill: 'Leader' },
                        { name: 'Lady Mae', skill: 'Dist' }
                    ],
                    team_delta2: [
                        { name: 'Michael Santos', skill: 'Driver' },
                        { name: 'Karl Magno', skill: 'Dist' }
                    ],
                    team_echo: [
                        { name: 'John Ray', skill: 'Leader' },
                        { name: 'Cath Sy', skill: 'Dist' }
                    ],
                    team_foxtrot: [
                        { name: 'Alex Torres', skill: 'Driver' }
                    ]
                }
            };
        }

        // Set default date to today
        document.getElementById('operation_date').valueAsDate = new Date();
    </script>
</body>
</html>