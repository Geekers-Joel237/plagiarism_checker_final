$(document).ready(function() {
    setInterval(async function () {
    //    await getCommentsOfPosts().then( async function(result) {
        
        await getnumber_mail();
        // await sleep(3000)
    // });
  
       
    }, 4000);

    

});


async function getCommentsOfPosts() {
    var bad = document.getElementById("badgess");
    var id = document.getElementById("user_id").value;
    // console.log(id);
    $.ajax({
        method: "GET",
        url: '/api/get_number_of_message/' + id,
        success: (result) => {
            // console.log(result);
            if(result == 'error'){
                iziToast.error({
                    title: 'error !',
                    message: 'something when wrong fetching chat unread number',
                    position: 'topRight'
                });
            }else{
                bad.textContent = result['data'];
            }
            
        },
        error: (error) => {
            console.log(error);
                iziToast.error({
                    title: 'error !',
                    message: 'something when wrong fetching chat unread number',
                    position: 'topRight'
                });
        }
    });

}

    async function getnumber_mail() {
        var mail = document.getElementById("mailges");
        var bad = document.getElementById("badgess");
        var other_num = document.getElementById("num_my_box");
        var id = document.getElementById("user_id").value;
        // console.log(id);
        $.ajax({
            method: "GET",
            url: '/api/get_number_of_mail/' + id,
            success: (result) => {
                // console.log(result['mailling']);
                if(result == 'error'){
                    iziToast.error({
                        title: 'error !',
                        message: 'something when wrong fetching mail number',
                        position: 'topRight'
                    });
                }else{
                    mail.textContent = result['num_mail'];
                    bad.textContent = result['data'];
                    // other_num.textContent='( '+result['data']+' )';
                    var cont = document.getElementById("content_3");
                    cont.textContent = '';

                    for (var i = 0; i < result['mailling'].length; i++) {
                        var a = document.createElement('a');
                        a.classList.add("dropdown-item");
                        a.href = "/user/mail";

                        var span1 = document.createElement('span');
                        span1.classList.add("dropdown-item-avatar");
                        span1.classList.add("text-white");

                        // var img1 = document.createElement('img');
                        // img1.classList.add("rounded-circle");
                        // img1.alt = "user";
                        // img1.src = "{{ asset('uploads/users')}}/"+(result['mailling'][i].mail_file != null ? result['mailling'][i].mail_file : '');
                       
                        var img1 = document.createElement('i');
                        img1.classList.add("far");
                        img1.classList.add("fa-user");
                        

                        var span2 = document.createElement('span');
                        span2.classList.add("dropdown-item-desc");

                        var span3 = document.createElement('span');
                        span3.classList.add("message-user");
                        span3.textContent = result['mailling'][i].user_send_id;
                        var span4 = document.createElement("span");
                        span4.classList.add("time");
                        span4.classList.add("messege-text");
                        span4.textContent = result['mailling'][i].mail_message;
                        var span5 = document.createElement("span");
                        span5.classList.add("time");
                        span5.textContent = result['mailling'][i].created_at;

                        //first add
                        span1.appendChild(img1);
                        span2.appendChild(span3);
                        span2.appendChild(span4);
                        span2.appendChild(span5);

                        a.appendChild(span1);
                        a.appendChild(span2);
                        cont.appendChild(a);
                    }

                }
                
            },
            error: (error) => {
                console.log(error);
                    iziToast.error({
                        title: 'error !',
                        message: 'something when wrong fetching mail number',
                        position: 'topRight'
                    });
            }
        });
}