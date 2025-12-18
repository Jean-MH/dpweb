/* ================= LISTAR ================= */
async function listar_temporales() {
    try {
        const url = new URL(base_url + 'control/VentaController.php');
        url.searchParams.append('tipo', 'listarTemporales');
        const res = await fetch(url);
        const json = await res.json();

        // Actualizar el mini-carrito en el header
        actualizar_mini_carrito(json.data || []);

        // Si estamos en la página de ventas, actualizamos la tabla grande
        const listaCompraEl = document.getElementById("lista_compra");
        if (!listaCompraEl) return; // Salir si no estamos en la página de ventas

        if (!json.status || !json.data || json.data.length === 0) {
            // Si no hay productos, limpia la tabla y los totales.
            listaCompraEl.innerHTML = '<tr><td colspan="5" class="text-center">No hay productos en el carrito.</td></tr>';
            act_subt_general_tabla([]); // Pasa un array vacío para resetear los totales
            return;
        }

        let html = '';
        json.data.forEach(t => {
            html += `
                <tr>
                    <td>${t.producto}</td>
                    <td>
                        <input type="number" class="form-control form-control-sm" value="${t.cantidad}"
                            onchange="actualizar_subtotal(${t.id}, this.value)">
                    </td>
                    <td>S/. ${t.precio}</td>
                    <td>S/. ${(t.precio * t.cantidad).toFixed(2)}</td>
                    <td>
                        <button class="btn btn-danger btn-sm"
                            onclick="eliminarTemporal(${t.id})">
                            Eliminar
                        </button>
                    </td>
                </tr>
            `;
        });

        listaCompraEl.innerHTML = html;
        // Pasamos los datos ya obtenidos para no hacer otra petición
        act_subt_general_tabla(json.data);
    } catch (error) {
        console.error("Error al listar temporales:", error);
    }
}

/* ================= AGREGAR ================= */
async function agregar_producto_temporal() {
    try {
        const id = document.getElementById("id_producto_venta").value;
        const cantidad = document.getElementById("producto_cantidad_venta").value;

        const datos = new FormData();
        datos.append("id_producto", id);
        datos.append("cantidad", cantidad);

        const res = await fetch(
            base_url + 'control/VentaController.php?tipo=registrarTemporal',
            { method: "POST", body: datos }
        );

        const json = await res.json();
        if (json.status) {
            listar_temporales();
        } else {
            alert(json.msg || "Error al agregar el producto.");
        }
    } catch (error) {
        console.error("Error al agregar producto temporal:", error);
    }
}

/* ================= ACTUALIZAR ================= */
async function actualizar_subtotal(id, cantidad) {
    try {
        const datos = new FormData();
        datos.append("id", id);
        datos.append("cantidad", cantidad);

        await fetch(
            base_url + 'control/VentaController.php?tipo=actualizarCantidadTemporalPorId',
            { method: "POST", body: datos }
        );

        listar_temporales();
    } catch (error) {
        console.error("Error al actualizar subtotal:", error);
    }
}

/* ================= TOTALES ================= */
function act_subt_general_tabla(temporales) {
    let subtotal = 0;
    // Si el array existe y tiene elementos, calcula el subtotal
    if (temporales && temporales.length > 0) {
        temporales.forEach(t => subtotal += t.precio * t.cantidad);
    }

    const igv = subtotal * 0.18;
    const total = subtotal + igv;

    const subtotalEl = document.getElementById("subtotal_general");
    const igvEl = document.getElementById("igv_general");
    const totalEl = document.getElementById("total_general");

    if(subtotalEl) subtotalEl.innerText = `S/. ${subtotal.toFixed(2)}`;
    if(igvEl) igvEl.innerText = `S/. ${igv.toFixed(2)}`;
    if(totalEl) totalEl.innerText = `S/. ${total.toFixed(2)}`;
}

/* ================= ELIMINAR ================= */
async function eliminarTemporal(id) {
    try {
        const datos = new FormData();
        datos.append("id", id);

        await fetch(
            base_url + 'control/VentaController.php?tipo=eliminarTemporal',
            { method: "POST", body: datos }
        );

        listar_temporales();
    } catch (error) {
        console.error("Error al eliminar temporal:", error);
    }
}

/* ================= MINI CARRITO (HEADER) ================= */
function actualizar_mini_carrito(items) {
    const contador = document.getElementById('cart-counter');
    const dropdownItems = document.getElementById('mini-cart-items');
    const totalEl = document.getElementById('mini-cart-total');

    if (!contador || !dropdownItems || !totalEl) return;

    if (!items || items.length === 0) {
        contador.innerText = '0';
        dropdownItems.innerHTML = '<div class="text-center p-2">El carrito está vacío.</div>';
        totalEl.innerText = 'S/ 0.00';
        return;
    }

    let total = 0;
    let html = '';
    let cantidadTotal = 0;

    items.forEach(item => {
        const subtotal = item.precio * item.cantidad;
        total += subtotal;
        cantidadTotal += parseInt(item.cantidad, 10);
        html += `
            <div class="cart-item">
                <div class="cart-item-details">
                    <div>${item.producto}</div>
                    <small class="text-muted">${item.cantidad} x S/ ${item.precio}</small>
                </div>
                <strong>S/ ${subtotal.toFixed(2)}</strong>
            </div>
        `;
    });

    contador.innerText = cantidadTotal;
    dropdownItems.innerHTML = html;
    totalEl.innerText = `S/ ${total.toFixed(2)}`;
}

// Ejecuta la función para cargar el carrito en cuanto el DOM esté listo.
document.addEventListener('DOMContentLoaded', function() {
    listar_temporales();
});

/* ================= BUSCAR CLIENTE POR DNI ================= */
async function buscarClientePorDni(dni) {
    try {
        const datos = new FormData();
        datos.append('dni', dni);

        const res = await fetch(
            base_url + 'control/ClientsController.php?tipo=buscarPorDNI',
            { method: 'POST', body: datos }
        );
        const json = await res.json();

        if (!json.status) {
            Swal.showValidationMessage(`Cliente no encontrado: ${json.msg}`);
            return false;
        }

        // Si se encuentra, se devuelve el objeto cliente para el siguiente paso
        return json.data;
    } catch (error) {
        Swal.showValidationMessage(`Error de red: ${error}`);
        return false;
    }
}

/* ================= REGISTRAR VENTA FINAL ================= */
async function registrarVentaFinal(idCliente) {
    try {
        const datos = new FormData();
        datos.append('id_cliente', idCliente);

        const res = await fetch(
            base_url + 'control/VentaController.php?tipo=registrarVenta',
            { method: 'POST', body: datos }
        );
        const json = await res.json();

        if (json.status) {
            // Venta exitosa, refrescamos el carrito (que ahora estará vacío)
            listar_temporales();
        }
    } catch (error) {
        console.error("Error al registrar la venta final:", error);
    }
}
