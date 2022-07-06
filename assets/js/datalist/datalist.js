/*function myFunction() {
    var input, filter, ul, li, a, i, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    ul = document.getElementById("myUL");
    li = ul.getElementsByTagName("li");
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0];
        txtValue = a.textContent || a.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
}

*/
function myFunction() {

    var input, filter, ul, li, a, i, txtValue;

    input = document.getElementById("datalist");
    filter = input.value.toUpperCase();

    ul = document.getElementById("myUL");
    a = ul.getElementsByTagName("a");

    for (i = 0; i < a.length; i++) {

        li = a[i].getElementsByTagName("li")[0];
        txtValue = li.textContent || li.innerText;

        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            a[i].style.display = "";
        } else {
            a[i].style.display = "none";
        }
    }
}