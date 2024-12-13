<!-- Aldrich Mira -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicant Form</title>
</head>
<body>
    <style>
        .scholarship-table th,
        .scholarship-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .scholarship-table th {
            background-color: #f2f2f2;
        }

        .view-btn {
            background-color: #1a237e;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .view-btn:hover {
            background-color: #283593;
        }
    </style>
    <form class="application-form" method="POST" action="" id="applyForm" style="display: none;">
            <div class="form-section">
                <h2>Applicant Information</h2>
                <div class="form-group">
                    <label for="fullName">Full Name:</label>
                    <input type="text" id="fullName" name="fullName" required>
                </div>
                <div class="form-group">
                    <label for="dob">Date of Birth:</label>
                    <input type="date" id="dob" name="dob" required>
                </div>
                <div class="form-group">
                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number:</label>
                    <input type="tel" id="phone" name="phone" required>
                </div>
                <div class="form-group">
                    <label for="studentId">Student ID:</label>
                    <input type="text" id="studentId" name="studentId" required>
                </div>
            </div>

            <div class="form-section">
                <h2>Educational Background</h2>
                <div class="form-group">
                    <label for="school">Current School/University:</label>
                    <input type="text" id="school" name="school" required>
                </div>
                <div class="form-group">
                    <label for="course">Course/Program Enrolled In:</label>
                    <input type="text" id="course" name="course" required>
                </div>
                <div class="form-group">
                    <label for="yearLevel">Year Level:</label>
                    <input type="text" id="yearLevel" name="yearLevel" required>
                </div>
            </div>

            <div class="instructions">
                <h3>Submission Instructions:</h3>
                <ol>
                    <li>After the review of your application, you will be notified via email regarding when and where to submit the required documents in person.</li>
                    <li>Make sure the email provided in the application is active and checked regularly to avoid missing the submission schedule.</li>
                    <li>Incomplete or late submissions after notification will not be processed.</li>
                </ol>
            </div>

            <button type="submit" name="apply" class="submit-btn">Apply</button>
        </form>
    </div>

    <script>
        function showApplicationForm() {
            document.getElementById('applyForm').style.display = 'block';
        }
    </script>
</body>
</html>