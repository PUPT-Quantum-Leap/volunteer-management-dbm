<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer Registration Form</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background-color: #f8fafc;
            min-height: 100vh;
            padding: 40px 20px;
        }

        .form-container {
            max-width: 900px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .logo {
            display: inline-block;
            margin-bottom: 20px;
        }

        .logo img {
            width: 80px;
            height: 80px;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(24, 119, 242, 0.2);
        }

        h1 {
            color: #1e293b;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .subtitle {
            color: #64748b;
            font-size: 16px;
        }

        .form-card {
            background-color: white;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(24, 119, 242, 0.05);
            border: 1px solid #e2e8f0;
        }

        .section-title {
            font-size: 20px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 24px;
            padding-bottom: 12px;
            border-bottom: 2px solid #1877F2;
            position: relative;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 60px;
            height: 2px;
            background: linear-gradient(90deg, #1877F2, #3b82f6);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 24px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #374151;
            margin-bottom: 8px;
        }

        label .required {
            color: #ef4444;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            color: #9ca3af;
            pointer-events: none;
        }

        input[type="text"],
        input[type="email"],
        input[type="date"],
        input[type="tel"],
        select,
        textarea {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.2s;
            outline: none;
            font-family: inherit;
            background-color: #ffffff;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="date"]:focus,
        input[type="tel"]:focus,
        select:focus,
        textarea:focus {
            border-color: #1877F2;
            box-shadow: 0 0 0 3px rgba(24, 119, 242, 0.1);
            background-color: #fefeff;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
            padding: 12px 16px;
        }

        select {
            cursor: pointer;
            background-color: white;
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 16px;
            padding-right: 40px;
        }

        .radio-group,
        .checkbox-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .radio-option,
        .checkbox-option {
            display: flex;
            align-items: center;
            padding: 8px 12px;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .radio-option:hover,
        .checkbox-option:hover {
            background-color: #f1f5f9;
        }

        input[type="radio"],
        input[type="checkbox"] {
            width: 18px;
            height: 18px;
            margin-right: 12px;
            cursor: pointer;
            accent-color: #1877F2;
        }

        .radio-option label,
        .checkbox-option label {
            margin: 0;
            cursor: pointer;
            font-weight: 400;
            color: #374151;
        }

        .emergency-contact {
            background: linear-gradient(135deg, #fef2f2 0%, #fef3f3 100%);
            border: 1px solid #fecaca;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 24px;
            position: relative;
        }

        .emergency-contact::before {
            content: '⚠️';
            position: absolute;
            top: -10px;
            left: 20px;
            background: white;
            padding: 4px 8px;
            border-radius: 50%;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .emergency-contact .section-title {
            color: #dc2626;
            border-bottom-color: #ef4444;
            font-size: 18px;
            margin-bottom: 20px;
            padding-left: 20px;
        }

        .submit-section {
            margin-top: 40px;
            padding-top: 32px;
            border-top: 1px solid #e2e8f0;
            text-align: center;
        }

        .submit-btn {
            width: 100%;
            max-width: 300px;
            padding: 16px 32px;
            background: linear-gradient(135deg, #1877F2 0%, #3b82f6 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(24, 119, 242, 0.3);
        }

        .submit-btn:hover {
            background: linear-gradient(135deg, #166fe5 0%, #2563eb 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(24, 119, 242, 0.4);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .form-card {
                padding: 24px;
                margin: 0 10px;
            }

            h1 {
                font-size: 28px;
            }

            .section-title {
                font-size: 18px;
            }
        }

        .helper-text {
            font-size: 12px;
            color: #64748b;
            margin-top: 4px;
        }

        /* Progress indicator */
        .progress-container {
            margin-bottom: 32px;
            text-align: center;
        }

        .progress-bar {
            width: 100%;
            height: 4px;
            background-color: #e2e8f0;
            border-radius: 2px;
            overflow: hidden;
            margin-bottom: 8px;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #1877F2, #3b82f6);
            width: 100%;
            transition: width 0.3s ease;
        }

        .progress-text {
            font-size: 12px;
            color: #64748b;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="header">
            <div class="logo">
                <img src="{{ asset('assets/nlcomlogo.jpg') }}" alt="NLCom Logo">
            </div>
            <h1>Volunteer Registration</h1>
            <p class="subtitle">Join our community and make a difference</p>
        </div>

        <div class="form-card">
            <form method="POST" action="{{ url('/volunteer-register') }}">
                @csrf

                <!-- Personal Information -->
                <div class="section-title">Personal Information</div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="firstName">First Name <span class="required">*</span></label>
                        <input type="text" id="firstName" name="first_name" required>
                    </div>
                    <div class="form-group">
                        <label for="lastName">Last Name <span class="required">*</span></label>
                        <input type="text" id="lastName" name="last_name" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Email Address <span class="required">*</span></label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="mobile">Mobile Number <span class="required">*</span></label>
                        <input type="tel" id="mobile" name="mobile" placeholder="09XX XXX XXXX" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="facebookName">Facebook Name</label>
                        <input type="text" id="facebookName" name="facebook_name">
                    </div>
                    <div class="form-group">
                        <label for="birthdate">Birthdate <span class="required">*</span></label>
                        <input type="date" id="birthdate" name="birthdate" required>
                    </div>
                </div>

                <div class="form-group full-width">
                    <label for="address">Complete Address <span class="required">*</span></label>
                    <textarea id="address" name="address" rows="3" required></textarea>
                </div>

                <!-- Education & Experience -->
                <div class="section-title" style="margin-top: 32px;">Education & Experience</div>

                <div class="form-group">
                    <label for="education">Educational Attainment <span class="required">*</span></label>
                    <select id="education" name="education" required>
                        <option value="">Select your highest education</option>
                        <option value="high-school">High School Graduate</option>
                        <option value="vocational">Vocational Course</option>
                        <option value="college-undergrad">College Undergraduate</option>
                        <option value="college-graduate">College Graduate</option>
                        <option value="masters">Master's Degree</option>
                        <option value="doctorate">Doctorate Degree</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="training">Training and Experience</label>
                    <textarea id="training" name="training" rows="4" placeholder="Please list any relevant training, workshops, seminars, or volunteer experience you have..."></textarea>
                </div>

                <div class="form-group">
                    <label for="skills">Skills or Hobbies</label>
                    <textarea id="skills" name="skills" rows="3" placeholder="Share your skills, talents, or hobbies that might be useful in volunteering..."></textarea>
                </div>

                <div class="form-group">
                    <label for="classes">Classes and Training Attended</label>
                    <textarea id="classes" name="classes" rows="3" placeholder="List any specific classes or training programs you've completed..."></textarea>
                </div>

                <!-- Volunteer Preferences -->
                <div class="section-title" style="margin-top: 32px;">Volunteer Preferences</div>

                <div class="form-group">
                    <label>Availability <span class="required">*</span></label>
                    <div class="checkbox-group">
                        <div class="checkbox-option">
                            <input type="checkbox" id="weekdays" name="availability[]" value="weekdays">
                            <label for="weekdays">Weekdays</label>
                        </div>
                        <div class="checkbox-option">
                            <input type="checkbox" id="weekends" name="availability[]" value="weekends">
                            <label for="weekends">Weekends</label>
                        </div>
                        <div class="checkbox-option">
                            <input type="checkbox" id="mornings" name="availability[]" value="mornings">
                            <label for="mornings">Mornings</label>
                        </div>
                        <div class="checkbox-option">
                            <input type="checkbox" id="afternoons" name="availability[]" value="afternoons">
                            <label for="afternoons">Afternoons</label>
                        </div>
                        <div class="checkbox-option">
                            <input type="checkbox" id="evenings" name="availability[]" value="evenings">
                            <label for="evenings">Evenings</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="volunteerArea">Where do you want to volunteer? <span class="required">*</span></label>
                    <select id="volunteerArea" name="volunteer_area" required>
                        <option value="">Select a ministry or area</option>
                        <option value="childrens-ministry">Children's Ministry</option>
                        <option value="youth-ministry">Youth Ministry</option>
                        <option value="worship-team">Worship Team</option>
                        <option value="media-production">Media & Production</option>
                        <option value="hospitality">Hospitality & Ushering</option>
                        <option value="prayer-team">Prayer Team</option>
                        <option value="outreach">Community Outreach</option>
                        <option value="administrative">Administrative Support</option>
                        <option value="facilities">Facilities & Maintenance</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Are you part of a Lifegroup? <span class="required">*</span></label>
                    <div class="radio-group">
                        <div class="radio-option">
                            <input type="radio" id="lifegroupYes" name="lifegroup" value="yes" required>
                            <label for="lifegroupYes">Yes</label>
                        </div>
                        <div class="radio-option">
                            <input type="radio" id="lifegroupNo" name="lifegroup" value="no">
                            <label for="lifegroupNo">No</label>
                        </div>
                    </div>
                </div>

                <!-- Emergency Contact -->
                <div class="emergency-contact">
                    <div class="section-title">Emergency Contact Information</div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="emergencyName">Contact Name <span class="required">*</span></label>
                            <input type="text" id="emergencyName" name="emergency_name" required>
                        </div>
                        <div class="form-group">
                            <label for="emergencyRelation">Relationship <span class="required">*</span></label>
                            <input type="text" id="emergencyRelation" name="emergency_relation" placeholder="e.g., Spouse, Parent, Sibling" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="emergencyPhone">Contact Number <span class="required">*</span></label>
                            <input type="tel" id="emergencyPhone" name="emergency_phone" placeholder="09XX XXX XXXX" required>
                        </div>
                        <div class="form-group">
                            <label for="emergencyEmail">Email Address</label>
                            <input type="email" id="emergencyEmail" name="emergency_email">
                        </div>
                    </div>
                </div>

                <!-- Submit -->
                <div class="submit-section">
                    <button type="submit" class="submit-btn">Submit Registration</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Client-side validation
        document.querySelector('form').addEventListener('submit', function(e) {
            // name is "availability[]" for checkbox group
            const availabilityChecked = document.querySelectorAll('input[name="availability[]"]:checked').length;
            if (availabilityChecked === 0) {
                e.preventDefault();
                alert('Please select at least one availability option.');
            }
        });
    </script>
</body>
</html>
