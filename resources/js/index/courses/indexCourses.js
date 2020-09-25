import utilities from '../../index/main';


utilities.addWhatchlist()


$(".filter-topic").click(function () {
    filterTopic(this.dataset.topicId , this.findParent(1).dataset.userSlug)

    for (let i = 0 ; i < $(".filter-topic").length; i++){
        $(".filter-topic")[i].firstElementChild.children[0].classList.remove("text-light")
    }

    this.firstElementChild.children[0].classList.add("text-light")



})

const filterTopic = async (idsTopic, userSlug )=>{

    const res = await axios.get(`/courses/${userSlug}`,{
        params: {
            "idsTopic" : idsTopic
        }

    })
    if(res.status==200){
        $('.content-filter').html($(res.data).find(".filter-data")
            .addClass('w-100 flex-wrap'))

    }
}






