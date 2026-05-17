function setLang(lang){
    if(lang === "mr"){
        document.getElementById("loginTitle").innerText = "लॉगिन करा";
    } else {
        document.getElementById("loginTitle").innerText = "Sign In";
    }
}

function scanSuccess(){
    alert("Attendance Recorded Successfully ✅");
}

function login() {
    let role = document.getElementById("role").value;

    if(role === "admin"){
        window.location.href = "admin-dashboard.html";
    }
    else if(role === "trainer"){
        window.location.href = "trainer-dashboard.html";
    }
    else{
        window.location.href = "member-dashboard.html";
    }
}

function deleteMember(btn){
    btn.parentElement.parentElement.remove();
}

function searchMember(){
    let input = document.getElementById("searchInput").value.toLowerCase();
    let rows = document.querySelectorAll("#memberTable tr");

    rows.forEach((row, index)=>{
        if(index === 0) return;
        let name = row.cells[1].innerText.toLowerCase();
        row.style.display = name.includes(input) ? "" : "none";
    });
}

window.onload = function(){
    const ctx = document.getElementById('attendanceChart');
    if(ctx){
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Mon','Tue','Wed','Thu','Fri','Sat'],
                datasets: [{
                    label: 'Members',
                    data: [20, 35, 40, 50, 45, 60],
                }]
            }
        });

        // Current Date Show
document.addEventListener("DOMContentLoaded", function(){
    const date = new Date();
    document.getElementById("currentDate").innerText = date.toDateString();
});
    }
}
