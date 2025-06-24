const signupButton=document.getElementById('signupButton');
const signinButton=document.getElementById('signinButton');
const signinForm=document.getElementById('signin');
const signupForm=document.getElementById('signup');
signupButton.addEventListener('click',function(){
    signinForm.style.display="none";
    signupForm.style.display="block";

})
signinButton.addEventListener('click',function(){
    signinForm.style.display="block";
    signupForm.style.display="none";

})
