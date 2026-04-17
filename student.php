<?php
$inputName = isset($_GET['input_name']) ? $_GET['input_name'] : "Guest";

$marks = [78, 45, 88, 56, 39, 67];

function calculateAverage($numbers) {
    $total = 0;
    foreach ($numbers as $num) {
        $total += $num;
    }
    $average = (float)$total / count($numbers);
    return $average;
}

function checkResult($mark) {
    if ($mark >= 50) {
        return "Pass";
    } else {
        return "Fail";
    }
}

$student = [
    "name" => "Asif",
    "id" => "CSE123",
    "cgpa" => 3.75
];

echo "<h2>Student Marksheet Program</h2>";
echo "<p><strong>Input Name from URL:</strong> " . htmlspecialchars($inputName) . "</p>";

echo "<h3>Student Marks</h3>";
foreach ($marks as $index => $mark) {
    echo "Student " . ($index + 1) . " Mark: " . $mark . " (" . checkResult($mark) . ")<br>";
}

$total = 0;
foreach ($marks as $mark) {
    $total += $mark;
}

$max = $marks[0];
$min = $marks[0];

foreach ($marks as $mark) {
    if ($mark > $max) {
        $max = $mark;
    }
    if ($mark < $min) {
        $min = $mark;
    }
}

$average = calculateAverage($marks);

$passCount = 0;
$failCount = 0;

foreach ($marks as $mark) {
    if ($mark >= 50) {
        $passCount++;
    } else {
        $failCount++;
    }
}

$totalStudents = count($marks);

$sortedMarks = $marks;
sort($sortedMarks);

echo "<h3>Calculated Result</h3>";
echo "Total Marks: " . $total . "<br>";
echo "Average Marks: " . number_format($average, 2) . "<br>";
echo "Maximum Marks: " . $max . "<br>";
echo "Minimum Marks: " . $min . "<br>";
echo "Passed Students: " . $passCount . "<br>";
echo "Failed Students: " . $failCount . "<br>";
echo "Total Number of Students: " . $totalStudents . "<br>";

echo "<h3>Sorted Marks (Ascending Order)</h3>";
foreach ($sortedMarks as $mark) {
    echo $mark . " ";
}

echo "<h3>Student Details</h3>";
foreach ($student as $key => $value) {
    echo ucfirst($key) . ": " . $value . "<br>";
}

echo "<h3>String Operations</h3>";
echo "Original Name: " . $student['name'] . "<br>";
echo "Name in Uppercase: " . strtoupper($student['name']) . "<br>";
echo "Length of Name: " . strlen($student['name']) . "<br>";
?>