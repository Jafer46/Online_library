const activepage = window.location.pathname;

foreach(link => {
    if(link.href.inludes(`${activepage}`)){
        console.log(link)
    }
})

