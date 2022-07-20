const path = 'http://levantou-scrapper.local';

export class ApiErrors {
    constructor(errors) {
        this.errors = errors;
    }
}


export async function apiFetch(endpoint, options = {}) {

    console.log(document.querySelector('meta[name="csrf-token"]'));
    const csrf_token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    console.log(csrf_token);
    if (csrf_token) {
        const response = await fetch(path + endpoint,
            {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrf_token
                },
                ...options
            }
        )

        let responseData = null;

        if (response.statusText === 'OK') {
            responseData = await response.json();
        }

        if (response.ok) {
            return responseData;
        }
        responseData = await response.json();
        throw new ApiErrors(responseData.errors);
    }

}
