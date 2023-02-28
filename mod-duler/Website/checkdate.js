function checkdate() {
    if(!!document.getElementById('enddate').value && !!document.getElementById('startdate').value){
        if (document.getElementById('enddate').value <= document.getElementById('startdate').value) {
            alert("Error: Start Date greater than End Date \n Please select new date");
            document.getElementById("EndDate").value = "";
        }
    }
    document.getElementById('submit_bt').click();
}