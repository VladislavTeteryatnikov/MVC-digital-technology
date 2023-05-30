const mainUrl = "http://localhost/MVC_digital_technology";

function remove(type, id) {
    if (confirm("Вы действительно хотите удалить эту запись?")) {
        window.location.href = `${mainUrl}/${type}/delete/${id}`;
    }
}