export const displayErrors = (parentElement, errors) => {
    clearErrors()
    for (const key in errors) {
        const parts = key.split(".")
        const formattedKey = parts.map((part, index) => {
            return index === 0 ? part : `[${part}]`;
        }).join("");
        const input = parentElement.find(`[name="${formattedKey}"]`)
        const parent = input.parent()
        input.addClass("is-invalid")
        parent.find("span.invalid-feedback").text(errors[key][0])
    }
}

export const clearErrors = () => {
    $("input.form-control").removeClass("is-invalid")
    $("select.form-control").removeClass("is-invalid")
    $("span.invalid-feedback").text("")
}
