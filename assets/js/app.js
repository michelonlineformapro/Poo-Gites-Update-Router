$(document).ready(function (){
    $("#toggle-admin").click(() => {
        $("#form-admin").slideToggle("slow")
    })

    $("#toggle-user").click(() => {
        $("#form-user").slideToggle("slow")
    })
})