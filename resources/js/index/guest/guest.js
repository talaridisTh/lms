import utilities from '../../index/main';

let instructors = document.querySelectorAll(".js-instructor-link");

instructors.forEach((instructor, idx) => {
    instructor.addEventListener("click", function () {

        instructors.forEach((instructor, idx) => {
            instructors[idx].findParent(2).classList.remove("bg-list")
        })

        this.findParent(2).classList.add("bg-list")

        axiosGuestCourse(this.dataset.userId)
        axiosInstructor(this.dataset.userId)

    })
})
const axiosInstructor = async (userId) => {
    try {
        const {data, status} = await axios.post("/guest/instructor", {
            userId
        })

        if (status == 200) {
            document.querySelector(".component-instructor").innerHTML = data
        }

    } catch (e) {
        console.log(e)
    }
}

const axiosGuestCourse = async (userId) => {
    try {
        const {data, status} = await axios.post("/guest/course", {
            userId
        })

        if (status == 200) {
            document.querySelector(".component-course").innerHTML = data
            let inputCourse = document.querySelectorAll(".input-course");
            let inputMaterial = document.querySelectorAll(".input-materials");
            let btnGuest = document.querySelector(".js-submit-guest")


            onClickInputCourse(inputCourse)
            onClickInputMaterial(inputMaterial)
            onBtnGuest(btnGuest, userId)
        }

    } catch (e) {
        console.log(e)
    }
}

const onClickInputCourse = (inputs) => {
    let courseId = []
    inputs.forEach((input, idx) => {
        input.addEventListener("click", async function () {
            if (!courseId.includes(this.dataset.courseId)) {
                courseId.push(this.dataset.courseId)
            } else {
                courseId = courseId.filter(item => item !== this.dataset.courseId)
            }

            axiosCourseInstructor(courseId)

        })
    })
}

const onClickInputMaterial = (inputs) => {
    let materialId = []
    inputs.forEach((input, idx) => {
        input.addEventListener("click", async function () {
            if (!materialId.includes(this.dataset.materialId)) {
                materialId.push(this.dataset.materialId)
            } else {
                materialId = materialId.filter(item => item !== this.dataset.materialId)
            }

            axiosMaterialInstructor(materialId)

        })
    })
}

const axiosCourseInstructor = async (courseId) => {
    try {
        const {data, status} = await axios.post("/guest/instructor-course", {
            courseId
        })

        if (status === 200) {
            document.querySelector(".component-instructor-course").innerHTML = data
        }
    } catch (e) {

        console.log(e)
    }
}

const axiosMaterialInstructor = async (materialId) => {
    console.log("")
    try {
        const {data, status} = await axios.post("/guest/instructor-material", {
            materialId
        })

        if (status === 200) {

            document.querySelector(".component-instructor-material").innerHTML = data
        }
    } catch (e) {

        console.log(e)
    }
}


const onBtnGuest = (btn, userId) => {

    btn.addEventListener("click", () => {
        let checkedCourses = document.querySelectorAll(".input-course:checked");
        let checkedMaterials = document.querySelectorAll(".input-materials:checked");


        axiosCreateGuestUser(userId, checkedCourses, checkedMaterials)
    })
}

const axiosCreateGuestUser = async (userId, courses, materials) => {

    let courseId  = []
    let materialId  = []

    courses.forEach(course =>courseId.push(course.dataset.courseId))
    materials.forEach(material =>materialId.push(material.dataset.materialId))


    try {
        const {status} = await axios.post("/guest/create/guest-user", {
            userId, courseId, materialId
        })
    } catch (e) {
        console.log(e)
    }
}
