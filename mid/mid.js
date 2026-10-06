// Calculate average and total per subject row
function calculateRowTotal(element) {
    var row = element.closest('.subject-row');
    if (!row) return;

    var mid1Input = row.querySelector('.mid1-input');
    var mid2Input = row.querySelector('.mid2-input');
    var totalInput = row.querySelector('.total-input');

    var mark1 = parseFloat(mid1Input.value);
    var mark2 = parseFloat(mid2Input.value);

    var hasM1 = !isNaN(mark1);
    var hasM2 = !isNaN(mark2);

    if (hasM1 && hasM2) {
        var avg = ((mark1 + mark2) / 2).toFixed(2);
        totalInput.value = avg;
    } else if (hasM1) {
        totalInput.value = mark1.toFixed(2);
    } else if (hasM2) {
        totalInput.value = mark2.toFixed(2);
    } else {
        totalInput.value = '';
    }
}

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

    // Helper function to load subjects
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
