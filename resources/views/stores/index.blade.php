<h1>asdfasdf</h1>
<script>
    fetch(`{{route('stores.index')}}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }

    }).then(res=>res.json())
    .then(res=>{
        console.log(res, 'asdf');
    })
</script>