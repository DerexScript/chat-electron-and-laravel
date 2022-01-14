document.addEventListener("DOMContentLoaded", async function(event) {
    let str = ``;
    let message = await req("http://localhost:8000/api/getMessage", "GET");
    if(message.length > 0){
        message.forEach(msg => {
            str += `
                <div class="card mb-2">
                    <div class="card-header">
                        ${msg.userSend}
                    </div>
                    <div class="card-body">
                        ${msg.msg}
                    </div>
                    <div class="card-footer text-muted">
                        ${msg.updated_at}
                    </div>
                </div>
            `;
        });
        document.querySelector("#msg").innerHTML = str;
    }
    let btnSendMsg = document.querySelector("#sendMsg");
    btnSendMsg.addEventListener('keydown', async evt => {
        //evt.preventDefault();
        if(evt.key == "Enter"){
            let headers = [
                 { "headerName": 'Content-type', "headerValue": "application/x-www-form-urlencoded" },
            ];
            formData = `msg=${evt.path[0].value}&user_id=1&for=1`;
            let msg = await req("http://localhost:8000/api/sendMessage", "post", formData, headers);
            evt.path[0].value = "";
            str = `
                    <div class="card-header">
                        ${msg.msg.userSend}
                    </div>
                    <div class="card-body">
                        ${msg.msg.msg}
                    </div>
                    <div class="card-footer text-muted">
                        ${msg.msg.updated_at}
                    </div>
            `;
            let div = document.createElement("div");
            div.classList.add("card");
            div.classList.add("mb-2");
            div.innerHTML = str;
            document.querySelector("#msg").appendChild(div);
        }
    });
});