const stages = document.getElementById('stages');

if (stages) {
    stages.addEventListener('click', e => {
        if (e.target.className==='btn btn-danger delete-Stage') {
            if (confirm('Are you sure you want to delete?')) {
                const id = e.target.getAttribute('data-id');

                fetch(`/admin/delete/${id}`, {
                    method: 'DELETE'
                }).then(res => window.location.reload());
            }
        }
    });
}
