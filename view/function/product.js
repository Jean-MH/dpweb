async function view_products() {
    try {
        let respuesta = await fetch(base_url + 'control/ProductoController.php?tipo=ver_productos', {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache'
        });
        json = await respuesta.json();
        contenidot = document.getElementById('content_products');
        if (json.status) {
            let cont = 1;
            json.data.forEach(producto => {
                let nueva_fila = document.createElement("tr");
                nueva_fila.id = "fila" + producto.id;
                nueva_fila.className = "filas_tabla";
                nueva_fila.innerHTML = `
                            <td>${cont}</td>
                            <td>${producto.codigo}</td>
                            <td>${producto.nombre}</td>
                            <td>${producto.precio}</td>
                            <td>${producto.stock}</td>
                            <td>${producto.categoria}</td>
                            <td>${producto.fecha_vencimiento}</td>
                            <td><svg id="barcode${producto.id}"></svg></td>
                            <td>
                                <a href="`+ base_url + `edit-product/` + producto.id + `">Editar</a>
                                <button class="btn btn-danger" onclick="fn_eliminar(` + producto.id + `);">Eliminar</button>
                            </td>
                `;
                cont++;
                contenidot.appendChild(nueva_fila);
                JsBarcode("#barcode" + producto.id, "" + producto.codigo, {
                        format: "pharmacode",
                        lineColor: "#4FB83B",
                        width: 3,
                        height: 30,
                        displayValue: false

                });
                });
                //json.data.forEach(producto => {
                //    JsBarcode("#barcode" + producto.id, "Hi world!");
                // });
            }
    } catch (e) {
            console.log('error en mostrar producto ' + e);
        }
    }
if (document.getElementById('content_products')) {
        view_products();
    }

    function validar_form(tipo) {
        let codigo = document.getElementById("codigo").value;
        let nombre = document.getElementById("nombre").value;
        let detalle = document.getElementById("detalle").value;
        let precio = document.getElementById("precio").value;
        let stock = document.getElementById("stock").value;
        let id_categoria = document.getElementById("id_categoria").value;
        let fecha_vencimiento = document.getElementById("fecha_vencimiento").value;
        let imagen = document.getElementById("imagen").value;
        if (codigo == "" || nombre == "" || detalle == "" || precio == "" || stock == "" || id_categoria == "" || fecha_vencimiento == "") {
            Swal.fire({
                title: "Error campos vacios!",
                icon: "error",
                draggable: true
            });
            return;
        }
        if (tipo == "nuevo") {
            registrarProducto();
        }
        if (tipo == "actualizar") {
            actualizarProducto();
        }

    }

    if (document.querySelector('#frm_product')) {
        // evita que se envie el formulario
        let frm_product = document.querySelector('#frm_product');
        frm_product.onsubmit = function (e) {
            e.preventDefault();
            validar_form("nuevo");
        }
    }

    async function registrarProducto() {
        try {
            //capturar campos de formulario (HTML)
            const datos = new FormData(frm_product);
            //enviar datos a controlador
            let respuesta = await fetch(base_url + 'control/ProductoController.php?tipo=registrar', {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: datos
            });
            let json = await respuesta.json();
            // validamos que json.status sea = True
            if (json.status) { //true
                alert(json.msg);
                document.getElementById('frm_product').reset();
            } else {
                alert(json.msg);
            }
        } catch (e) {
            console.log("Error al registrar Producto:" + e);
        }
    }
    async function cargar_categorias() {
        let respuesta = await fetch(base_url + 'control/CategoriaController.php?tipo=ver_categorias', {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
        });
        let json = await respuesta.json();
        let contenido = '<option value="">Seleccione</option>';
        if (json && Array.isArray(json.data) && json.data.length) {
            json.data.forEach(categoria => {
                // Use the categoria id as the option value
                contenido += '<option value="' + (categoria.id || '') + '"> ' + (categoria.nombre || '') + ' </option>';
            });
        } else {
            console.warn('cargar_categorias: no hay categorias', json);
        }
        console.log('Categorias options:', contenido, json);
        const selCat = document.getElementById("id_categoria");
        if (selCat) selCat.innerHTML = contenido;
    }

    async function cargar_proveedores() {
        try {
            let respuesta = await fetch(base_url + 'control/UsuarioController.php?tipo=verProveedores', {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
            });

            const text = await respuesta.text();
            if (!text) {
                console.warn('verProveedores: respuesta vacía');
                const selEmpty = '<option value="">Seleccione</option>';
                const selEl = document.getElementById('id_proveedor');
                if (selEl) selEl.innerHTML = selEmpty;
                return;
            }

            let json;
            try {
                json = JSON.parse(text);
            } catch (err) {
                console.error('verProveedores: respuesta no JSON:', text);
                const selEl = document.getElementById('id_proveedor');
                if (selEl) selEl.innerHTML = '<option value="">Seleccione</option>';
                return;
            }

            let contenido = '<option value="">Seleccione</option>';
            if (json.status && Array.isArray(json.data)) {
                json.data.forEach(proveedor => {
                    contenido += '<option value="' + proveedor.id + '"> ' + proveedor.razon_social + ' </option>';
                });
            }
            console.log('Proveedores options:', contenido, json);
            const select = document.getElementById("id_proveedor");
            if (select) select.innerHTML = contenido;
        } catch (e) {
            console.error('Error en cargar_proveedores:', e);
            const selEl = document.getElementById('id_proveedor');
            if (selEl) selEl.innerHTML = '<option value="">Seleccione</option>';
        }
    }

    async function fn_eliminar(id) {
        if (window.confirm("¿Confirmar eliminar producto?")) {
            eliminar(id);
        }
    }

    async function eliminar(id) {
        let datos = new FormData();
        datos.append('id_producto', id);
        try {
            let respuesta = await fetch(base_url + 'control/ProductoController.php?tipo=eliminar', {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: datos
            });
            const text = await respuesta.text();
            console.log('Respuesta del servidor (producto):', text);
            let json;
            try {
                json = JSON.parse(text);
            } catch (parseErr) {
                console.error('Error al parsear JSON:', parseErr, 'Texto:', text);
                alert("Error: respuesta inválida del servidor. Ver consola para detalles.");
                return;
            }
            if (!json.status) {
                alert("Error al eliminar producto: " + (json.msg || 'Error desconocido'));
                console.log('Respuesta completa:', json);
                return;
            } else {
                alert(json.msg);
                // reload the page to show updated list
                location.reload();
            }
        } catch (e) {
            console.error("Error al eliminar producto: " + e);
            alert("Error al conectar con el servidor: " + e.message);
        }
    }


