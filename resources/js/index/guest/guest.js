import utilities from '../../index/main';

let instructors = document.querySelectorAll(".js-instructor-link");

instructors.forEach((instructor, idx) => {
    instructor.addEventListener("click", function () {

        instructors.forEach((instructor, idx) => {
            instructors[idx].findParent(2).classList.remove("bg-list")
        })

        this.findParent(2).classList.add("bg-list")

        axiosGuestCourse(this.dataset.userId, this.dataset.userSlug)
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
            onPreview(userId, $(".input-course:checked"), "course")
            onPreview(userId, $(".input-materials:checked"), "material")

        }

    } catch (e) {
        console.log(e)
    }
}

const axiosGuestCourse = async (userId, userSlug) => {
    try {
        const {data, status} = await axios.post("/guest/course", {
            userId
        })

        if (status == 200) {
            document.querySelector(".component-course").innerHTML = data
            let inputCourse = $(".input-course");
            let inputMaterial = $(".input-materials");
            let btnGuest = document.querySelector(".js-submit-guest")


            onClickInputCourse(inputCourse, userId)
            onClickInputMaterial(inputMaterial, userId)
            onBtnGuest(btnGuest, userId, userSlug)
        }

    } catch (e) {
        console.log(e)
    }
}

const onClickInputCourse = (inputs, userId) => {
    inputs.change(function () {

        onPreview(userId, $(".input-course:checked"), "course")

    })

}


const onClickInputMaterial = (inputs, userId) => {

    inputs.change(function () {
        onPreview(userId, $(".input-materials:checked"), "material")
    })

}

const onPreview = (userId, modelInput, model) => {
    console.log(model)
    let courseId = [];

    let checkedCourses = modelInput;
    console.log(checkedCourses)

    if (model === "material") {
        for (let i = 0; i < checkedCourses.length; i++) {
            if (!courseId.includes(checkedCourses[i].dataset.materialId)) {
                courseId.push(checkedCourses[i].dataset.materialId)
            }

        }
        axiosMaterialInstructor(courseId, userId)
    } else {
        for (let i = 0; i < checkedCourses.length; i++) {
            if (!courseId.includes(checkedCourses[i].dataset.courseId)) {
                courseId.push(checkedCourses[i].dataset.courseId)
            }

        }

        axiosCourseInstructor(courseId, userId)
    }


}


const axiosCourseInstructor = async (courseId, userId) => {
    try {
        const {data, status} = await axios.post("/guest/instructor-course", {
            courseId,
            userId
        })

        if (status === 200) {
            document.querySelector(".component-instructor-course").innerHTML = data
        }
    } catch (e) {

        console.log(e)
    }
}

const axiosMaterialInstructor = async (materialId) => {
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


const onBtnGuest = (btn, userId, userSlug) => {

    btn.addEventListener("click", () => {
        let checkedCourses = document.querySelectorAll(".input-course:checked");
        let checkedMaterials = document.querySelectorAll(".input-materials:checked");


        axiosCreateGuestUser(userId, checkedCourses, checkedMaterials, userSlug)
    })
}

const axiosCreateGuestUser = async (userId, courses, materials, userSlug) => {

    let courseId = []
    let materialId = []

    courses.forEach(course => courseId.push(course.dataset.courseId))
    materials.forEach(material => materialId.push({
        "material": material.dataset.materialId,
        "courses": material.dataset.courseId
    }))

    try {
        const {status} = await axios.post("/guest/create/guest-user", {
            userId, courseId, materialId
        })
        if (status === 200) {

            document.querySelector(".guest-link").innerHTML = `<a href ="${window.location.origin}/guest/temp/link/${userSlug}"> link</a>`

        }
    } catch (e) {
        console.log(e)
    }
}
