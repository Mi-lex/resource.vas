export const getJson = url => {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
        }).done(resolve)
            .fail(reject);
    });
}