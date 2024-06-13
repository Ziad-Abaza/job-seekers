const searchBar = document.querySelector(".search input"),
    searchIcon = document.querySelector(".search button"),
    usersList = document.querySelector(".users-list");

document.addEventListener("DOMContentLoaded", function() {
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "get_users.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = JSON.parse(xhr.response);
                console.log(data);
                if (data) {
                    usersList.innerHTML = "";

                    var usersDiv = document.createElement("ul");
                    data.forEach(function(user) {
                        var userDiv = document.createElement("li");
                        userDiv.innerHTML = `
                    <div style="cursor: pointer;" class="user_container height-50px" onclick="sendUserData(${user.id});">
                        <div class= "height-50px width-50px rounded-circle overflow-hidden">
                           <img src="${user.image}" alt="${user.name}" class="img-fluid w-full h-full">
                        </div>
                        
                        <p style="margin-left:20px;">${user.name}</p>
                    </div>
                        <hr>
                            `;
                        usersDiv.appendChild(userDiv);
                    });
                    usersList.appendChild(usersDiv);
                }
            }
        }
    };
    xhr.send();
});

function sendUserData(user_id) {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", `test.php?user=${user_id}`, true);
    xhr.onload = function() {
        if (xhr.status == 200) {
            const userData = JSON.parse(xhr.responseText);
            constructChatArea(userData);
        } else {
            console.error("Error loading chat area");
        }
    };
    xhr.send();
}

// Construct the chat area HTML components
function constructChatArea(userData) {
    const chatArea = document.getElementById("chatArea");
    chatArea.innerHTML = `
        <div style=" display: grid;
        grid-row-gap: 10px;
    grid-template-columns: 1fr; /* Single column */
    grid-template-rows: auto 1fr auto; /* Header, chat messages, message input */
    height: 100vh; /* Adjust as needed */">
        <div class="chating_user d-flex height-50px user_container margin: 20px 0 20px 0;">
            <div class="height-50px width-50px rounded-circle overflow-hidden">
                <img src="${userData.image}" alt="" class="img-fluid w-full h-full">
            </div>
                <p style="margin-left:20px;">${userData.name}</p>
        </div>
        <div class="chat-box" style="overflow:auto; height:100%;">
        
        </div>
        <form action="#" class="typing-area">
            <input type="text" class="incoming_id" name="incoming_id" value="${userData.id}" hidden>
        <div class="d-flex" style="padding-right: 15px;">
            <input type="text" name="message" class="input-field" placeholder="Type a message here..." autocomplete="off">
            <button><i class="fa-regular fa-paper-plane"></i></button>
        </div>
            </form>
        </div>
    `;

    // Create a unique timestamp to ensure script is not cached
    const timestamp = Date.now();

    // Remove existing user_chat.js script
    const existingScript = document.querySelector(
        "script[src='js/user_chat.js']"
    );
    if (existingScript) {
        existingScript.parentNode.removeChild(existingScript);
    }

    // Append user_chat.js script with unique query parameter
    const script = document.createElement("script");
    script.src = `js/user_chat.js?timestamp=${timestamp}`;
    document.head.appendChild(script);
}