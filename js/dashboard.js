/*
**********************************************************
* Function: loadContent
**********************************************************
*/
function loadContent(page, element) {
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("main-content").innerHTML = this.responseText;
            
            // Remove active class from all nav links
            var navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(function(navLink) {
                navLink.classList.remove('active');
            });

            // Add active class to the clicked nav link
            element.classList.add('active');
        }
    };
    xhttp.open("GET", "load-content.php?page=" + page, true);
    xhttp.send();
}

/*
**********************************************************
* Function: deleteUser
**********************************************************
*/
function deleteUser(userId) {
    if (confirm('Are you sure you want to delete this user?')) {
        // Send delete request to the server
        const xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if (this.responseText === "User deleted successfully") {
                    fetchUsers();
                } else {
                    alert('Error deleting user.');
                }
            }
        };
        xhttp.open("POST", "Dashboard/delete.php", true);
        xhttp.setRequestHeader("Content-type", "application/json");
        xhttp.send(JSON.stringify({ user_id: userId }));
    }
}


/*
**********************************************************
* Function: fetchUsers
**********************************************************
 */
function fetchUsers() {
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("user-list").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "Dashboard/users.php", true);
    xhttp.send();
}

/*
**********************************************************
* Function: deleteJob
**********************************************************
*/
function deleteJob(jobId) {
    if (confirm('Are you sure you want to delete this job?')) {
        // Send delete request to the server
        const xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if (this.responseText === "Job deleted successfully") {
                    fetchJobs();
                } else {
                    alert('Error deleting job.');
                }
            }
        };
        xhttp.open("POST", "Dashboard/delete.php", true); 
        xhttp.setRequestHeader("Content-type", "application/json");
        xhttp.send(JSON.stringify({ job_id: jobId }));
    }
}


/*
**********************************************************
* Function: fetchJobs
**********************************************************
 */
function fetchJobs() {
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("tab-1").innerHTML = this.responseText; 
        }
    };
    xhttp.open("GET", "Dashboard/job-list.php", true); 
    xhttp.send();
}

/*
**********************************************************
* Function: deleteCompany
**********************************************************
*/
function deleteCompany(companyId) {
    if (confirm('Are you sure you want to delete this company?')) {
        // Send delete request to the server
        const xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4) {
                if (this.status == 200) {
                    if (this.responseText.trim() === "company deleted successfully") {
                        fetchCompanies();
                    } else {
                        alert('Error deleting company: ' + this.responseText);
                    }
                } else {
                    alert('Error: ' + this.status);
                }
            }
        };
        xhttp.open("POST", "Dashboard/delete.php", true); 
        xhttp.setRequestHeader("Content-type", "application/json");
        xhttp.send(JSON.stringify({ company_id: companyId }));
    }
}



/*
**********************************************************
* Function: fetchCompany
**********************************************************
 */

function fetchCompanies() {
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("filteredResults").innerHTML = this.responseText; 
        }
    };
    xhttp.open("GET", "Dashboard/companies.php", true); 
    xhttp.send();
}