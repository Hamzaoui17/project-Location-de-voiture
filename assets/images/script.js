let pass;
let passvalue =document.getElementById("form3Example4");
let para=document.getElementById("01");
passvalue.addEventListener('input' ,function(event){
    if(event.target.value.length<8){
         para.textContent="mot doit passer 8 caracteres";
    }else{
         para.textContent="";
    }

})
let search = document.getElementById("search");
search.addEventListener("onclick",function(){
  
})

