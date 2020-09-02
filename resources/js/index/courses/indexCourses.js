import utilities from '../../dashboard/main';


$(".filter-topic").click(function () {
    filterTopic(this.dataset.topicId , this.findParent(1).dataset.userSlug)

})

const filterTopic = async (idsTopic, userSlug )=>{

    const res = await axios.get(`/courses/${userSlug}`,{
        params: {
            "idsTopic" : idsTopic
        }

    })
    if(res.status==200){

    }
}

