$(document).ready(function () {
    // When department changes, load semesters
    $("#department").change(function () {
        var department = $(this).val();
        if (!department) {
            $("#semester").html('<option value="">Select Semester</option>');
            $("#marksForm").hide();
            $("#subject-fields").html('');
            return;
        }

        $.ajax({
            type: "POST",
            url: "get_semesters.php",
            data: { department: department },
            success: function (response) {
                $("#semester").html(response);
                $("#marksForm").hide();
                $("#subject-fields").html('');
            }
        });
    });

    function fetchSubjects() {
        var rollNumber = $("#rollNumber").val().trim();
        var department = $("#department").val();
        var semester = $("#semester").val();

        if (!rollNumber) {
            alert("Please enter the student Roll / PIN Number first.");
            return;
        }

        if (!department || !semester) {
            alert("Please select both Department and Semester.");
            return;
        }

        $.ajax({
            type: "POST",
            url: "get_subjects.php",
            data: { semester: semester, department: department },
            success: function (response) {
                $("#subject-fields").html(response);
                $("#marksForm").slideDown();
            },
            error: function () {
                alert("Failed to load subjects. Please try again.");
            }
        });
    }

    $("#load-subjects-btn").on("click", function () {
        fetchSubjects();
    });

    $("#semester").change(function () {
        if ($("#rollNumber").val().trim() && $("#department").val() && $(this).val()) {
            fetchSubjects();
        }
    });
});
