function toggleMeals(mealsId) {
    var mealsDiv = document.getElementById(mealsId);
    
    if (mealsDiv) {
        if (mealsDiv.style.display === "none" || mealsDiv.style.display === "") {
            mealsDiv.style.display = "block";
        } else {
            mealsDiv.style.display = "none";
        }
    }
}

document.addEventListener("DOMContentLoaded", function () {
    let days = document.querySelectorAll(".day");
    
    days.forEach((day, index) => {
        let mealDiv = day.querySelector(".meals");
        let button = day.querySelector(".toggle-button");
        
        if (mealDiv && button) {
            let newId = `meals${index + 1}`;
            mealDiv.id = newId;
            button.setAttribute("onclick", `toggleMeals('${newId}')`);
        }
    });
});
