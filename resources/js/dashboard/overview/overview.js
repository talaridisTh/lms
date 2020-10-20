import Chart from 'chart.js';

const topCourses = document.getElementsByClassName("js-top-courses");
const topCoursesData = categoryStudentsCountBuilder( topCourses );
const topCoursesCanvas = document.getElementById("top-courses");

const topCoursesChart = new Chart(topCoursesCanvas, {
	type: 'doughnut',
	position: "bottom",
    data: {
        labels: topCoursesData.titles,
        datasets: [{
            data: topCoursesData.students,
            backgroundColor: [
				'rgba(83, 109, 230, 1)',
				'rgba(16, 196, 105, 1)',
				'rgba(249, 200, 81, 1)',
				'rgba(255, 91, 91, 1)',
				'rgba(2, 168, 181, 1)'
			],
            borderColor: "#fff"/* [
                'rgba(112, 135, 235, 1)',
                'rgba(43, 238, 140, 1)',
                'rgba(250, 215, 127, 1)',
                'rgba(255, 102, 102, 1)',
                'rgba(2, 203, 217, 1)'
            ] */,
            borderWidth: 1
        }]
    },
    options: {
		cutoutPercentage: 60,
		legend: {
			position: "bottom",
			labels: {
				fontColor: "#a5b3c0"

			}
		},
    }
});

const topBundles = document.getElementsByClassName("js-top-bundles");
const topBundlesData = categoryStudentsCountBuilder( topBundles );
const topBundlesCanvas = document.getElementById("top-bundles");

const topBundlesChart = new Chart(topBundlesCanvas, {
	type: 'doughnut',
	position: "bottom",
    data: {
        labels: topBundlesData.titles,
        datasets: [{
            data: topBundlesData.students,
            backgroundColor: [
				'rgba(83, 109, 230, 1)',
				'rgba(16, 196, 105, 1)',
				'rgba(249, 200, 81, 1)',
				'rgba(255, 91, 91, 1)',
				'rgba(2, 168, 181, 1)'
			],
            borderColor: "#fff"/* [
                'rgba(112, 135, 235, 1)',
                'rgba(43, 238, 140, 1)',
                'rgba(250, 215, 127, 1)',
                'rgba(255, 102, 102, 1)',
                'rgba(2, 203, 217, 1)'
            ] */,
            borderWidth: 1
        }]
    },
    options: {
		cutoutPercentage: 60,
		legend: {
			position: "bottom",
			labels: {
				fontColor: "#a5b3c0"

			}
		},		
    }
});

function categoryStudentsCountBuilder( element ) {
	const titles = [];
	const students = [];

	for ( let i = 0; i < element.length; i++ ) {
		titles.push( element[i].dataset.title );
		students.push( +element[i].dataset.students );
	}

	return {
		titles, students

	}
};