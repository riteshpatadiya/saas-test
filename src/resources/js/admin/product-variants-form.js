$(function () {
    const $store = $('#store_id');
    const $product = $('#product_id');

    if ($store.length === 0 || $product.length === 0) {
        return;
    }

    const urlTemplate = $product.data('products-url-template');

    function resetProducts(placeholderText = 'Select product') {
        $product.empty();
        $product.append($('<option/>', { value: '', text: placeholderText }));
    }

    function setDisabled(disabled) {
        $product.prop('disabled', !!disabled);
    }

    function buildUrl(storeId) {
        return String(urlTemplate || '').replace('__STORE__', encodeURIComponent(storeId));
    }

    function loadProductsByStore(storeId, selectedProductId = '') {
        if (!storeId || !urlTemplate) {
            resetProducts();
            setDisabled(true);
            $product.val('');
            return;
        }

        resetProducts('Loading...');
        setDisabled(true);

        $.ajax({
            url: buildUrl(storeId),
            method: 'GET',
            dataType: 'json',
            headers: { Accept: 'application/json' },
        })
            .done(function (json) {
                const items = Array.isArray(json && json.data) ? json.data : [];

                resetProducts();

                items.forEach(function (item) {
                    $product.append(
                        $('<option/>', {
                            value: String(item.id),
                            text: item.name,
                        })
                    );
                });

                setDisabled(false);

                if (selectedProductId) {
                    $product.val(String(selectedProductId));
                }
            })
            .fail(function () {
                resetProducts();
                setDisabled(false);
            });
    }

    // Initial state:
    // - create: no products are preloaded -> disable until store selected
    // - edit: products may be preloaded for selected store -> keep enabled
    if ($product.find('option').length <= 1) {
        setDisabled(true);
    }

    $store.on('change', function () {
        const storeId = $(this).val();
        $product.val('');
        loadProductsByStore(storeId, '');
    });
});

