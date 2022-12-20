const Cron = async () => {
    try{
        const url = await fetch('./api/check_for_finished_reservation.php')
        const res = await url.json()

        console.log(res)
    }
    catch(error){
        console.log(error)
    }
    finally{
        setTimeout(t => Cron(), 5000)
    }
}

Cron()