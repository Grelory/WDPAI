const search = document.querySelector('#search');
const projectContainer = document.querySelector(".projects");

search.addEventListener("keyup", async function (event) {
    if (event.key !== "Enter") {
        return;
    }

    event.preventDefault();

    const data = {search: this.value};

    const response = await fetch("/search", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    });

    const projects = await response.json();
    
    projectContainer.innerHTML = "";
    projects.forEach(project => {
        createProject(project);
    });
});


function createProject(project) {
    const template = document.querySelector("#project-card-template");

    const clone = template.content.cloneNode(true);

    const image = clone.querySelector("img");
    image.src = project.photoUrl;

    const title = clone.querySelector("h2");
    title.innerHTML = project.title;

    const description = clone.querySelector("p");
    description.innerHTML = project.description;

    projectContainer.appendChild(clone);
}
