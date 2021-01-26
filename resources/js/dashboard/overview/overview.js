import Chart from 'chart.js';

const topCourses = document.getElementsByClassName("js-top-courses");
const topCoursesData = categoryStudentsCountBuilder( topCourses );
const topCoursesCanvas = document.getElementById("top-courses");

new Chart(topCoursesCanvas, {
	type: 'doughnut',
	position: "bottom",
    data: {
        labels: topCoursesData.titles,
        datasets: [{
            data: topCoursesData.students,
            backgroundColor: [
				'rgba(83, 109, 230, 0.8)',
				'rgba(16, 196, 105, 0.8)',
				'rgba(249, 200, 81, 0.8)',
				'rgba(255, 91, 91, 0.8)',
				'rgba(2, 168, 181, 0.8)'
			],
            borderColor: "#fff",
            borderWidth: 1
        }]
    },
    options: {
		cutoutPercentage: 50,
		legend: {
			position: "bottom",
			labels: {
				fontColor: "#a5b3c0",
				fontFamily: "Open Sans, sans-serif"

			}
		},		
    }
});

// const topBundles = document.getElementsByClassName("js-top-bundles");
// const topBundlesData = categoryStudentsCountBuilder( topBundles );
// const topBundlesCanvas = document.getElementById("top-bundles");

// new Chart(topBundlesCanvas, {
// 	type: 'doughnut',
// 	position: "bottom",
//     data: {
//         labels: topBundlesData.titles,
//         datasets: [{
//             data: topBundlesData.students,
//             backgroundColor: [
// 				'rgba(83, 109, 230, 0.8)',
// 				'rgba(16, 196, 105, 0.8)',
// 				'rgba(249, 200, 81, 0.8)',
// 				'rgba(255, 91, 91, 0.8)',
// 				'rgba(2, 168, 181, 0.8)'
// 			],
//             borderColor: "#fff",
//             borderWidth: 1
//         }]
//     },
//     options: {
// 		cutoutPercentage: 50,
// 		legend: {
// 			position: "bottom",
// 			labels: {
// 				fontColor: "#a5b3c0",
// 				fontFamily: "Open Sans, sans-serif"

// 			}
// 		},		
//     }
// });

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

const newStudentsCanvas = document.getElementById("new-students-per-month");
let newStudentsData = JSON.parse(newStudentsCanvas.dataset.data);
const currentMonth = new Date().getMonth();
const refMonths = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ];

for ( let i = 0; i < refMonths.length; i++ ) {

	if ( i >= newStudentsData.length ) {
		newStudentsData[i] = {
			month: refMonths[i],
			students: 0
		};
		continue;
	}

	if ( newStudentsData[i].month === i + 1 && typeof newStudentsData[i].month != "undefined" ) {
		newStudentsData[i].month = refMonths[i];
	}
	else {
		newStudentsData.splice( i, 0, {
			month: refMonths[i],
			students: 0
		});
	}

}

const moveMonths = newStudentsData.splice( currentMonth + 1);
newStudentsData = moveMonths.concat(newStudentsData)

const months = []
const students = [];

for ( let i = 0; i < newStudentsData.length; i++ ) {
	months.push(newStudentsData[i].month);
	students.push(newStudentsData[i].students);
}

new Chart(newStudentsCanvas, {
    type: 'line',
    data: {
		labels: months,
		datasets: [{
			label: "Μαθητές",
			data: students,
			lineTension: 0,
			borderColor: "rgb(83, 109, 230)",
			backgroundColor: "rgba(83, 109, 230, 0.1)",
			pointRadius: 5,
			pointBackgroundColor: "rgb(83, 109, 230)",
		}]
	},
	options: {
		maintainAspectRatio: false,
		legend: {
			labels: {
				fontColor: "#8391a2",
				fontFamily: "Open Sans, sans-serif"
			}
		},
		scales: {
			xAxes: [{
				ticks: {
					fontColor: "#8391a2",
					fontFamily: "Open Sans, sans-serif"
				},
				gridLines: {
					color: "#464f5b"
				}
			}],
			yAxes: [{
				ticks: {
					fontColor: "#8391a2",
					fontFamily: "Open Sans, sans-serif",
					stepSize: 2
				},
				gridLines: {
					color: "#464f5b"
				}
			}],
			scaleLabel: {
				fontColor: "#8391a2",
				fontFamily: "Open Sans, sans-serif"
			}
		}
	}
});

const topicStatsCanvas = document.getElementById("courses-per-topic");
const topicStats = JSON.parse(topicStatsCanvas.dataset.topicStats);
const topic = titleCountSeparator(topicStats);

new Chart(topicStatsCanvas, {
	type: 'doughnut',
	position: "bottom",
    data: {
        labels: topic.title,
        datasets: [{
            data: topic.count,
            backgroundColor: [
				'rgba(83, 109, 230, 0.8)',
				'rgba(16, 196, 105, 0.8)',
				'rgba(249, 200, 81, 0.8)',
				'rgba(255, 91, 91, 0.8)',
				'rgba(2, 168, 181, 0.8)'
			],
            borderColor: "#fff",
            borderWidth: 1
        }]
    },
    options: {
		cutoutPercentage: 50,
		legend: {
			position: "bottom",
			labels: {
				fontColor: "#a5b3c0",
				fontFamily: "Open Sans, sans-serif"

			}
		},
    }
});

function titleCountSeparator( arrayData ) {
	const title = [];
	const count = [];

	for ( let i = 0; i < arrayData.length; i++ ) {
		title.push(arrayData[i].title);
		count.push(arrayData[i].count);
	}

	return { title, count }
}