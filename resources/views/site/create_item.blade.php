<!doctype html>
<html>
<head>
    <meta charset='utf-8'>
    <title>create_item</title>
    <link rel="icon" href="../images/icons/favicon.jpg">
    <meta name='viewport' content='width=device-width,intial-scale=0.1'>
    <link rel="icon"  href="{{URL::asset('images/icons/favicon.jpg')}}">
    <link rel='stylesheet' href="{{URL::asset('site/css/create_item.css')}}">
</head>
<body>
    <div class="container">
        <div class='form-header'>
            create item
        </div>
        <form method="POST" action="{{url('create/item')}}" class='form' enctype="multipart/form-data">
             @csrf
            <div class='input-center'>
                <input type='text' name='supcat_id' placeholder="type supCatId">
                <input type='text' name='cat_id' placeholder="type CatId">
                <input type="text" name="name" placeholder="Name : " autofocus id='name' >
                @error('name')
                    <small>{{$message}}</small>
                @enderror
                <input type="file" name="image"  title='choose image' id='image' >
                @error('image')
                    <small>{{$message}}</small>
                @enderror
                <input type="text" name="salary"  placeholder="salary by dolar" title="salary by dolar"  id='salary' >
                @error('salary')
                    <small>{{$message}}</small>
                @enderror
                <textarea name='details' placeholder="details"  ></textarea>
                @error('details')
                    <small>{{$message}}</small>
                @enderror
             </div>
            <button type="submit">create</button>
        </form>
    </div>
    <script>
        var name = document.getElementsById("name");
        name.addEventListener('focus',function(){
            naem.style.opacity='1';
        });
    </script>
</body>
</html>
