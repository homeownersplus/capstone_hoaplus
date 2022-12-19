<div class="dropdown-item" onClick="showNotif()">
    <div class="position-relative">
        <i class="fa-solid fa-bell fa-sm fa-fw mr-2 text-gray-400"></i>
        Notification
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger notif-count">
        </span>
    </div>
</div>

<script>
    const fetchUnreadNotif = async() => {
        try{
            const url = await fetch('../api/fetch_notif_count.php')
            const res = await url.json()
            console.log(res)
            if(res.counts){
                document.querySelectorAll('.notif-count').forEach(e => {
                    e.classList.remove('d-none')
                    e.textContent = res.counts
                })

            }else{
                document.querySelectorAll('.notif-count').forEach(e => e.classList.add('d-none'))
            }
            let temp = ''
            for(const i of res.notif){
                temp += `
                <div class="mb-2 p-2 rounded border">
                    ${i.description}
                </div>
                `
            }
            document.querySelector('.notif-body').innerHTML = temp
        }
        catch(e){
            console.log("Error occured while trying to fetch notification : ",e)
        }
        finally{
            setTimeout(() => {
                fetchUnreadNotif()
            }, 1500);
        }
    }

    const showNotif = async () => {
        $('#notif-modal').modal('show')

        try{
            const url = await fetch('../api/update_notif_count.php')
            const res = await url.json()
            console.log(res)
        }
        catch(e){
            console.log("Error occured while trying to update notification : ",e)
        }
    }
    fetchUnreadNotif()
    const closeNotif = () => $('#notif-modal').modal('hide')
</script>