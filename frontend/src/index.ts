import './scss/styles.scss'
import 'whatwg-fetch'

const form = document.getElementById('invite') as HTMLFormElement;
form.addEventListener("submit", async function(event) {
    event.preventDefault();

    const successArea = document.getElementById('success_area');
    const errorArea = document.getElementById('error_area');

    const result = await fetch(form.action, {
        method: form.method,
        body: new URLSearchParams(new FormData(form) as any)
    })
        .then((response: Response) => {
            if (!response.ok) throw Error(response.statusText);
            return response;
        })
        .then((response: Response) => response.json())
        .then((json: string | boolean) => {
            if (json === true) {
                errorArea.innerHTML = '';
                successArea.innerHTML = '<div class="alert alert-success">Thank you! Your invitation will be sent shortly! Feel free to invite another guest.</div>';
                const guestNameInput = document.getElementById('guest_name') as HTMLInputElement;
                guestNameInput.value = '';
            } else {
                successArea.innerHTML = '';
                errorArea.innerHTML = '<div class="alert alert-warning">' + json + '</div>';
            }
        })
        .catch(error => console.log(error));
});
