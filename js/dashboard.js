function loadContent(page, element) {
    fetch(`load-content.php?page=${page}`)
        .then(response => response.text())
        .then(data => {
            document.getElementById("main-content").innerHTML = data;
            document.querySelectorAll('.nav-link').forEach(navLink => navLink.classList.remove('active'));
            element.classList.add('active');

            if (page.includes('job-list.php')) {
                fetchItems('job_postings', updateJobsUI);
            } else if (page.includes('companies.php')) {
                fetchItems('companies', updateCompaniesUI);
            } else if (page.includes('users.php')) {
                fetchItems('users', updateUsersUI);
            }
        })
        .catch(error => console.error('Error loading content:', error));
}

function deleteItem(action, itemId, table, callback) {
    if (confirm('Are you sure you want to delete this item?')) {
        fetch('api.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action, id: itemId, table })
        })
        .then(response => response.json())
        .then(data => {
            if (data.message.includes('deleted successfully')) {
                callback();
            } else {
                alert(`Error deleting item: ${data.error}`);
            }
        })
        .catch(error => console.error('Error:', error));
    }
}

function fetchItems(table, callback) {
    let endpoint = `api.php?action=fetchItems&table=${table}`;

    fetch(endpoint)
        .then(response => response.json())
        .then(data => callback(data))
        .catch(error => console.error(`Error fetching items:`, error));
}

function updateUsersUI(users) {
    const userList = document.getElementById("user-list");
    userList.innerHTML = users.length ? users.map(user => `
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <img class="img-fluid border rounded-circle" src="${user.image}" alt="" style="width: 50px; height: 50px;">
                        <div class="ms-3">
                            <h5 class="card-title mb-1">
                                <i class="fas fa-user text-primary"></i> ${user.name}
                            </h5>
                            <p class="card-text mb-0">
                                <i class="fas fa-envelope text-primary"></i> ${user.email}
                            </p>
                            <p class="card-text mb-0">
                                <i class="fas fa-briefcase text-primary"></i> ${user.role}
                            </p>
                            <p class="card-text mb-0">
                                <i class="fas fa-phone text-primary"></i> ${user.phone}
                            </p>
                            <p class="card-text mb-0">
                                <i class="fas fa-toggle-${user.status ? 'on' : 'off'} text-primary"></i> ${user.status ? 'Active' : 'Inactive'}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        <i class="far fa-calendar-alt text-primary me-2"></i>${user.created_at}
                    </small>
                    <button class="btn btn-danger btn-sm" onclick="deleteItem('deleteItem', ${user.id}, 'users', () => fetchItems('users', updateUsersUI))">
                        <i class="fas fa-trash-alt"></i> Delete
                    </button>
                </div>
            </div>
        </div>
    `).join('') : '<p>No Users Found!</p>';
}

function updateJobsUI(jobs) {
    const allJobs = document.getElementById('all-jobs');
    const fullTimeJobs = document.getElementById('full-time-jobs');
    const partTimeJobs = document.getElementById('part-time-jobs');

    allJobs.innerHTML = '';
    fullTimeJobs.innerHTML = '';
    partTimeJobs.innerHTML = '';

    jobs.forEach(job => {
        const jobMarkup = `
            <div class="job-item px-4 mx-5">
                <div class="row g-4">
                    <div class="col-sm-12 col-md-8 d-flex align-items-center">
                        <img class="flex-shrink-0 img-fluid border rounded" src="${job.image}" alt="" style="width: 80px; height: 80px;">
                        <div class="text-start ps-4">
                            <h5 class="mb-3">${job.title}</h5>
                            <span class="text-truncate me-3"><i class="fa fa-map-marker-alt text-primary me-2"></i>${job.location}</span>
                            <span class="text-truncate me-3"><i class="far fa-clock text-primary me-2"></i>${job.type}</span>
                            <span class="text-truncate me-0"><i class="far fa-money-bill-alt text-primary me-2"></i>${job.salary}</span>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 d-flex flex-column align-items-start align-items-md-end justify-content-center">
                        <div class="d-flex mb-3 gap-2">
                            <a class="btn btn-primary btn-sm-hover" href="job-detail.php?jobId=${job.id}">Show</a>
                            <button class="btn btn-danger btn-sm" onclick="deleteItem('deleteItem', ${job.id}, 'job_postings', () => fetchItems('job_postings', updateJobsUI))">
                                <i class="fas fa-trash-alt"></i> Delete
                            </button>
                        </div>
                        <small class="text-truncate"><i class="far fa-calendar-alt text-primary me-2"></i>${job.created_at}</small>
                    </div>
                </div>
            </div>
        `;
        const targetElement = job.type === 'full time' ? fullTimeJobs : job.type === 'part time' ? partTimeJobs : allJobs;
        targetElement.innerHTML += jobMarkup;
        allJobs.innerHTML += jobMarkup;
    });

    if (!jobs.length) {
        allJobs.innerHTML = 'No jobs found!';
    }
}

function updateCompaniesUI(companies) {
    const filteredResults = document.getElementById("filteredResults");
    filteredResults.innerHTML = companies.length ? companies.map(company => `
        <div class="card my-4 category-card my-0" data-category="${company.category}">
            <div class="card-header">
                <h2>${company.category}</h2>
            </div>
            <div class="card-body px-2 py-0">
                <div class="row m-0">
                    <div class="col-lg-3 col-md-4 col-sm-6 company-card my-3" data-name="${company.name}" data-category="${company.category}" id="company-${company.id}">
                        <div class="card h-100">
                            <div class="d-flex align-items-center p-3">
                                <div class="rounded-circle overflow-hidden" style="width: 75px; height: 75px;">
                                    <img src="${company.image}" class="img-fluid" alt="${company.name}">
                                </div>
                                <div class="ml-3 flex-grow-1">
                                    <h5 class="card-title mb-1">${company.name}</h5>
                                    <p class="card-text mb-1 fs-6">${company.category}</p>
                                    <p class="card-text mb-1"><i class="fas fa-map-marker-alt"></i> ${company.location}</p>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-between">
                                <a class="btn btn-primary btn-sm" href="company-detail.php?companyId=${company.id}">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <button class="btn btn-danger btn-sm" onclick="deleteItem('deleteItem', ${company.id}, 'companies', () => fetchItems('companies', updateCompaniesUI))">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `).join('') : '<p>No Companies Found!</p>';
}

document.addEventListener('DOMContentLoaded', () => {
    fetchItems('job_postings', updateJobsUI);
    fetchItems('companies', updateCompaniesUI);
    fetchItems('users', updateUsersUI);
});
