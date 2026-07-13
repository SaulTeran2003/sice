const $inputNames = document.querySelectorAll('input[name="name[]"]');
const $datalistName = document.querySelector("#name-list");
const url = "api";

$inputNames.forEach(($inputName) => {
  $inputName.addEventListener("keyup", async function() {
    let values = [];

    if ($inputName.value.length < 4) {
      $datalistName.innerHTML = "";
      values = [];
    }

    if ($inputName.value.length >= 4) {
      $datalistName.innerHTML = "";
      values = (await callApi("nombre", $inputName.value)) ?? [];

      values.forEach((value) => {
        $datalistName.insertAdjacentHTML(
          "beforeend",
          `<option value="${value.NOMBRE}">`
        );
      });
    }
  });
});

async function callApi(endpoint, value) {
  try {
    const response = await fetch(
      `${url}/${endpoint}.php?${endpoint}=${value}`,
      {
        method: "GET",
        //mode: "no-cors"
      }
    );
    console.log(response);
    return await response.json();
  } catch (error) {
    throw new Error(error);
  }
}
