# Tienda_Raul_PachecoRopero

![Portada](https://files.catbox.moe/qhnxlm.png "Portada")


## ÍNDICE
1. ESTRUCTURA DEL PROYECTO
2. MODELS
    - usuario
    - producto
    - pedido
    - categoria
    - carrito
3. CONTROLLERS
    - UsuarioController
    - ProductoController
    - PedidoController
    - CategoriaController
    - CarritoController
    - DashboardController
    - ErrorController

4. LIB
    - DBConnection
    - Pages
    - Router

5. ROUTES

6. UTILS

7. VIEWS
    - dashboard
        - inicio

    - layout
        - header
        - footer

    - usuario
        - login
        - registro
        - modificarDatos
    
    - producto
        - lista
        - crearProducto
        - gestionarProductos
        - modificar

    - categoria
        - mostrarCategorias
        - crearCategoria
        - modificar
    
    - pedidos
        - mostrarPedidos
        -  formularioPago

    - carrito
        - mostrarCarrito

    - error

# 1. ESTRUCTURA DEL PROYECTO

La estructura de mi proyecto está organizada de manera modular y clara, permitiendo que las distintas partes del sistema estén separadas y sea más fácil mantener y escalar el proyecto. Estas son cada una de las carpetas y archivos principales:

## 1. `config/`
Esta carpeta generalmente contiene archivos de configuración para la aplicación. Aquí se guardan configuraciones de la base de datos, rutas, parámetros de la aplicación y otras configuraciones globales.

### Ejemplos:
- `config/.env`: Archivo que contiene las credenciales usadas en la aplicación.

## 2. `Database/`
Esta carpeta contiene archivos relacionados con la gestión de la base de datos.


## 3. `public/`
Esta carpeta suele contiene los archivos públicos que se sirven directamente al navegador, como imágenes, archivos CSS, JavaScript, etc. 

### Ejemplos:
- `imgs/`: Archivos de imagen utilizados en la interfaz de usuario (por ejemplo, logotipos, iconos, etc.).

## 4. `src/`
Esta es la carpeta principal donde se encuentra todo el código fuente de la aplicación. Contiene los controladores, modelos, rutas, vistas, utilidades y demás lógica de la aplicación.

### 4.1 `Controllers/`
Esta carpeta contiene los controladores, que son responsables de manejar las solicitudes HTTP y coordinar la respuesta. Los controladores se encargan de recibir las solicitudes, interactuar con los modelos y devolver las vistas correspondientes.

### Ejemplos:
- `UsuarioController.php`: Controlador que maneja las acciones de usuario, como el registro, login, etc.
- `CategoriaController.php`: Controlador que maneja las acciones relacionadas con categorías de productos.

### 4.2 `Lib/`
Esta carpeta contiene bibliotecas o clases adicionales que no encajan estrictamente en los controladores, modelos o vistas, pero que son necesarias para la aplicación.

### Ejemplos:
- `Router.php`: Es la clase que maneja el enrutamiento de las URLs a sus respectivos controladores.

### 4.3 `Models/`
Aquí se encuentran los modelos, que representan las entidades de la base de datos y la lógica de acceso a los datos. Los modelos son responsables de interactuar con la base de datos para obtener, almacenar o modificar la información.

### Ejemplos:
- `Usuario.php`: Modelo que representa la entidad de usuario en la base de datos.
- `Producto.php`: Modelo que representa los productos en la base de datos.

### 4.4 `Routes/`
Contiene las rutas que definen cómo se manejan las solicitudes HTTP en tu aplicación. Cada ruta se mapea a un controlador y acción específica.

### Ejemplos:
- `Routes.php`: Archivo que define las rutas para las diversas funcionalidades de la aplicación (registro, login, productos, etc.).

### 4.5 `Utils/`
Contiene funciones utilitarias o clases auxiliares que puedan ser utilizadas en varias partes del proyecto.

### 4.6 `Views/`
Esta carpeta contiene las vistas, que son los archivos que se muestran al usuario. Los controladores envían datos a las vistas, que luego las renderizan y las devuelven al usuario. La carpeta está organizada en subcarpetas que corresponden a distintas secciones de la aplicación.

### Ejemplos:
- `carrito/`: Vistas relacionadas con el carrito de compras.
- `categoria/`: Vistas relacionadas con la gestión de categorías de productos.
- `dashboard/`: Vistas del panel de administración.
- `layout/`: Plantillas generales que se usan en varias vistas, como cabecera, pie de página y menús.
- `pedidos/`: Vistas para gestionar los pedidos.
- `producto/`: Vistas para la gestión de productos.
- `usuario/`: Vistas relacionadas con la gestión de usuarios, como el registro, login, etc.

## 5. Resumen
La estructura de mi proyecto está organizada de manera modular y clara, con las siguientes capas:
- **Config**: Archivos de configuración global.
- **Database**: Manejo de la base de datos.
- **Public**: Archivos accesibles públicamente (CSS, imágenes, etc.).
- **Src**: El núcleo de tu aplicación con controladores, modelos, rutas, vistas y utilidades.

Cada una de estas carpetas tiene una función específica, lo que te permite mantener tu código organizado, fácil de mantener y escalar.


# 2. MODELS

# Usuario


El modelo `Usuario` gestiona las operaciones relacionadas con los usuarios en el sistema, como la creación, autenticación y actualización de datos. Utiliza la clase `DBConnection` para interactuar con la base de datos.

## Propiedades

- **id**: Identificador único del usuario.
- **nombre**: Nombre del usuario.
- **apellidos**: Apellidos del usuario.
- **email**: Dirección de correo electrónico del usuario.
- **password**: Contraseña del usuario (generalmente encriptada).
- **rol**: Rol del usuario (por ejemplo, admin o usuario regular).
- **db**: Instancia de la clase `DBConnection` para interactuar con la base de datos.

## Métodos

### 1. Constructor (`__construct`)
Inicializa las propiedades del usuario y crea una nueva conexión a la base de datos.

### 2. Métodos Getters y Setters
Permiten acceder y modificar las propiedades del objeto `Usuario`.

### 3. `fromArray`
Crea un objeto `Usuario` a partir de un array de datos (por ejemplo, datos obtenidos de la base de datos).

### 4. `desconecta`
Cierra la conexión a la base de datos.

### 5. `getById`
Obtiene un usuario de la base de datos por su ID.

### 6. `createUsuario`
Crea un nuevo usuario en la base de datos.

### 7. `login`
Valida la autenticación de un usuario comparando su email y contraseña.

### 8. `getByEmail`
Busca un usuario en la base de datos por su email.

### 9. `getByEmailAndPassword`
Busca un usuario por email y contraseña, y los verifica.

### 10. `validarDatosRegistro`
Valida los datos de registro del usuario (nombre, apellidos, email y contraseña).

### 11. `validarDatosLogin`
Valida los datos para el login (email y contraseña).

### 12. `modificarDatosUsuario`
Permite modificar los datos de un usuario, excluyendo su rol.

### 13. `modificarDatosAdmin`
Permite modificar todos los datos de un usuario (incluido el rol), solo accesible por un administrador.

## Funcionalidad de seguridad

- **Contraseña**: Utiliza `password_verify` para comparar contraseñas, asegurando que la contraseña almacenada en la base de datos esté cifrada.
- **Validación de entrada**: Usa funciones de filtrado y validación para asegurar que los datos de entrada sean correctos y seguros, por ejemplo, usando `FILTER_SANITIZE_SPECIAL_CHARS` y `FILTER_VALIDATE_EMAIL`.

## Manejo de errores

- En varios métodos se captura cualquier excepción de PDO (base de datos) y se registra el error, evitando que la aplicación se caiga.
- Utiliza `rowCount()` y `fetch()` de PDO para comprobar si las consultas devuelven resultados válidos.

# Producto


El modelo `Producto` gestiona las operaciones relacionadas con los productos en el sistema, como la creación, actualización, eliminación, y recuperación de productos de la base de datos.

## Propiedades

- **id**: Identificador único del producto.
- **categoriaId**: ID de la categoría a la que pertenece el producto.
- **nombre**: Nombre del producto.
- **descripcion**: Descripción del producto.
- **precio**: Precio del producto.
- **stock**: Cantidad disponible en stock del producto.
- **oferta**: Oferta asociada al producto.
- **imagen**: Ruta de la imagen asociada al producto.
- **fecha**: Fecha de creación del producto.
- **db**: Instancia de la clase `DBConnection` para interactuar con la base de datos.

## Métodos

### 1. Constructor (`__construct`)
Inicializa las propiedades del producto y crea una nueva conexión a la base de datos.

### 2. Métodos Getters y Setters
Permiten acceder y modificar las propiedades del objeto `Producto`.

### 3. `getAll`
Obtiene todos los productos de la base de datos.

### 4. `createProducto`
Crea un nuevo producto en la base de datos. Verifica si el producto ya existe antes de insertarlo.

### 5. `getProductosByCategoria`
Obtiene los productos de una categoría específica.

### 6. `getStockById`
Obtiene el stock de un producto dado su ID.

### 7. `updateStock`
Actualiza el stock de un producto específico.

### 8. `updateProducto`
Actualiza los detalles de un producto específico en la base de datos.

### 9. `getImagenById`
Obtiene la imagen asociada a un producto por su ID.

### 10. `getProductoById`
Obtiene los detalles de un producto por su ID.

### 11. `deleteProducto`
Elimina un producto de la base de datos dado su ID.

### 12. `checkAndCreateImageDir`
Verifica y crea el directorio para almacenar imágenes de productos si no existe.

### 13. `getPaginatedProductos`
Obtiene productos paginados, ideal para mostrar en múltiples páginas.

### 14. `getPaginatedProductosByCategoria`
Obtiene productos paginados de una categoría específica.

## Funcionalidad de seguridad

- **Validación**: Realiza verificaciones para asegurarse de que el producto no exista previamente en la base de datos antes de ser creado.
- **Gestión de imágenes**: Verifica y crea un directorio para las imágenes de los productos si no existe.

## Manejo de errores

- En varios métodos, se captura cualquier excepción de PDO (base de datos) y se registra el error, evitando que la aplicación se caiga.
- Los métodos devuelven `false` en caso de error y se aseguran de cerrar correctamente la conexión a la base de datos.

# Pedido

El modelo `Pedido` gestiona las operaciones relacionadas con los pedidos en el sistema, como la creación, recuperación, actualización del estado y gestión de productos en los pedidos.

## Propiedades

- **id**: Identificador único del pedido.
- **usuarioId**: ID del usuario que realizó el pedido.
- **provincia**: Provincia de destino del pedido.
- **localidad**: Localidad de destino del pedido.
- **direccion**: Dirección de destino del pedido.
- **coste**: Coste total del pedido.
- **estado**: Estado del pedido (ej. "pendiente", "enviado").
- **fecha**: Fecha en que se realizó el pedido.
- **hora**: Hora en que se realizó el pedido.
- **db**: Instancia de la clase `DBConnection` para interactuar con la base de datos.

## Métodos

### 1. Constructor (`__construct`)
Inicializa las propiedades del pedido y crea una nueva conexión a la base de datos mediante la clase `DBConnection`.

### 2. Métodos Getters y Setters
Permiten acceder y modificar las propiedades del objeto `Pedido` (ej. `getId()`, `setId()`, `getEstado()`, etc.).

### 3. `createPedido`
Crea un nuevo pedido en la base de datos insertando los detalles del pedido (usuario, dirección, coste, estado, fecha y hora). Retorna `true` si la creación es exitosa, `false` en caso de error.

### 4. `getPedidosByUsuario`
Obtiene todos los pedidos de un usuario específico a partir de su ID. Los pedidos se devuelven ordenados por ID de manera descendente.

### 5. `updateEstadoPedido`
Actualiza el estado de un pedido dado su ID y un nuevo estado.

### 6. `getAll`
Obtiene todos los pedidos de la base de datos, ordenados por ID de manera descendente.

### 7. `getProductosPedidoFromSession`
Recupera los productos del carrito de compras de la sesión actual y calcula el coste total de cada producto.

### 8. `getPedidoById`
Obtiene los detalles de un pedido específico (incluyendo información del usuario) mediante el ID del pedido.

### 9. `createLineaPedido`
Crea una línea de pedido asociando un producto con un pedido y la cantidad comprada, insertando esta información en la base de datos.

## Funcionalidad de seguridad

- **Validación de entrada**: Verifica los datos de los pedidos antes de insertarlos en la base de datos.
- **Gestión de errores**: Utiliza `try-catch` para manejar posibles excepciones al interactuar con la base de datos, asegurándose de que la aplicación no se caiga.

## Manejo de errores

- En todos los métodos que interactúan con la base de datos, se captura cualquier excepción de `PDO` y se maneja adecuadamente, retornando `false` en caso de error.
- Los errores se gestionan mediante un manejo adecuado de las excepciones, y se cierran correctamente las conexiones y cursos después de cada operación en la base de datos.

# Categoria

El modelo `Categoria` gestiona las operaciones relacionadas con las categorías en el sistema, como la creación, actualización, eliminación y recuperación de categorías de la base de datos.

## Propiedades

- **id**: Identificador único de la categoría.
- **nombre**: Nombre de la categoría.
- **db**: Instancia de la clase `DBConnection` para interactuar con la base de datos.

## Métodos

### 1. Constructor (`__construct`)
Inicializa las propiedades de la categoría y crea una nueva conexión a la base de datos mediante la clase `DBConnection`.

### 2. Métodos Getters y Setters
Permiten acceder y modificar las propiedades del objeto `Categoria` (ej. `getId()`, `setId()`, `getNombre()`, `setNombre()`).

### 3. `getAll`
Obtiene todas las categorías de la base de datos, ordenadas por ID de manera descendente. Retorna un array con los datos de las categorías o un array vacío si no hay categorías.

### 4. `createCategoria`
Crea una nueva categoría en la base de datos. Antes de insertarla, verifica si la categoría ya existe. Retorna `true` si la categoría se crea correctamente y `false` si la categoría ya existe o ocurre un error.

### 5. `getCategoriaById`
Obtiene una categoría específica mediante su ID. Retorna los detalles de la categoría o `false` si no se encuentra la categoría.

### 6. `updateCategoria`
Actualiza el nombre de una categoría en la base de datos dada su ID. Retorna `true` si la categoría se actualiza correctamente, y `false` si no se actualiza ninguna fila.

### 7. `deleteCategoria`
Elimina una categoría de la base de datos. Antes de eliminarla, elimina todos los productos asociados a esa categoría. Retorna `true` si la categoría se elimina correctamente, y `false` en caso de error.

## Funcionalidad de seguridad

- **Verificación de existencia**: El método `createCategoria` verifica si una categoría con el mismo nombre ya existe antes de crear una nueva.
- **Eliminación de dependencias**: En el método `deleteCategoria`, antes de eliminar una categoría, se eliminan los productos asociados para evitar que queden huérfanos en la base de datos.

## Manejo de errores

- En todos los métodos que interactúan con la base de datos, se captura cualquier excepción de `PDO` y se maneja adecuadamente, retornando `false` en caso de error.
- Los errores se gestionan mediante un manejo adecuado de las excepciones, y se cierran correctamente las conexiones y cursos después de cada operación en la base de datos.

# Carrito

El modelo `Carrito` gestiona los productos añadidos al carrito de compras de un usuario, permitiendo manipular los detalles de los productos en el carrito, como el nombre, precio, cantidad y el identificador único del carrito.

## Propiedades

- **id**: Identificador único del carrito.
- **nombre**: Nombre del producto en el carrito.
- **precio**: Precio del producto en el carrito.
- **cantidad**: Cantidad del producto en el carrito.
- **db**: Instancia de la clase `DBConnection` para interactuar con la base de datos.

## Métodos

### 1. Constructor (`__construct`)
Inicializa la conexión a la base de datos mediante la clase `DBConnection`.

### 2. Métodos Getters y Setters
Permiten acceder y modificar las propiedades del objeto `Carrito` (ej. `getId()`, `setId()`, `getNombre()`, `setNombre()`, `getPrecio()`, `setPrecio()`, `getCantidad()`, `setCantidad()`).


# 3. CONTROLLERS

# UsuarioController

El **`UsuarioController`** gestiona las operaciones relacionadas con los usuarios, como el registro, inicio de sesión, cierre de sesión y la modificación de datos de usuario.

## Métodos principales

### 1. **`__construct()`**
   - Inicializa la clase `Pages` y carga las variables de entorno necesarias desde un archivo `.env`.

### 2. **`registro()`**
   - Gestiona el registro de usuarios. 
   - Recibe los datos de registro a través de un formulario POST, valida la información y guarda al usuario en la base de datos.
   - Si el registro es exitoso, se envía un correo de confirmación al usuario.

### 3. **`sendConfirmationEmail(Usuario $usuario)`**
   - Método privado que envía un correo de confirmación al usuario después de un registro exitoso utilizando la librería `PHPMailer`.

### 4. **`login()`**
   - Maneja el inicio de sesión de los usuarios.
   - Valida los datos ingresados (correo y contraseña) y, si son correctos, inicia sesión guardando los datos del usuario en la sesión.
   - Si se marca la opción "recordarme", guarda una cookie con el correo del usuario para que recuerde su sesión.

### 5. **`logout()`**
   - Maneja el cierre de sesión del usuario.
   - Elimina la sesión y la cookie de usuario, redirigiendo al usuario a la página principal.

### 6. **`modificarDatos(int $usuarioId)`**
   - Permite a los usuarios modificar sus propios datos o a los administradores modificar cualquier dato de un usuario.
   - Verifica si el usuario tiene permisos para modificar los datos y actualiza la base de datos con los nuevos valores.
   - Si el usuario es un administrador, puede cambiar todos los datos, incluidos el nombre, el correo y el rol.

## Control de errores
- En cada acción, si ocurre un error (por ejemplo, al guardar datos o validar la autenticación), se almacenan mensajes de error en la sesión, que luego se muestran en la vista.

## Consideraciones adicionales
- **Autenticación**: El controlador asegura que el usuario esté autenticado antes de realizar ciertas acciones (modificación de datos, cierre de sesión).
- **Seguridad**: Se emplea hashing de contraseñas con `password_hash()` y se utilizan variables de entorno para la configuración de correo electrónico.

Este controlador gestiona de manera centralizada las funcionalidades principales relacionadas con el manejo de usuarios, garantizando un flujo adecuado para el registro, login, logout y edición de perfiles.

# ProductoController

El **`ProductoController`** gestiona las operaciones relacionadas con los productos, incluyendo la creación, modificación, eliminación y visualización de productos, así como la paginación de productos.

## Métodos principales

### 1. **`__construct()`**
   - Inicializa las instancias de las clases `Pages`, `Producto` y `CarritoController`.

### 2. **`getProductos()`**
   - Obtiene todos los productos utilizando el modelo `Producto`.

### 3. **`gestionarProductos(int $page = 1)`**
   - Muestra la lista de productos con paginación.
   - Verifica si el usuario está autenticado antes de mostrar los productos.
   - Renderiza la vista `gestionarProductos` con los productos actuales y la información de paginación.

### 4. **`createProducto()`**
   - Muestra el formulario para crear un nuevo producto y maneja la creación del producto.
   - Verifica si el usuario está autenticado y valida los datos recibidos.
   - Si los datos son válidos, guarda el producto en la base de datos y maneja la subida de una imagen opcional.
   - Si la creación es exitosa, muestra un mensaje de éxito, de lo contrario, muestra errores.

### 5. **`modificarProducto($id)`**
   - Muestra el formulario para modificar un producto específico.
   - Verifica si el usuario está autenticado y si el producto existe.
   - Si el producto no existe, se muestra un error 404, si existe, se renderiza la vista de modificación.

### 6. **`updateProducto($id)`**
   - Actualiza los datos de un producto con los nuevos valores proporcionados.
   - Verifica que los datos son válidos y maneja la subida de una nueva imagen.
   - Si la actualización es exitosa, muestra un mensaje de éxito, de lo contrario, muestra errores.

### 7. **`deleteProducto(int $id)`**
   - Elimina un producto de la base de datos por su ID.
   - Verifica si el usuario está autenticado antes de proceder con la eliminación.
   - Muestra un mensaje de éxito si la eliminación es exitosa, o un error si ocurre algún problema.

## Consideraciones adicionales
- **Autenticación**: El controlador asegura que el usuario esté autenticado antes de realizar ciertas acciones (como crear, modificar o eliminar productos).
- **Subida de imágenes**: Si un producto tiene una imagen asociada, se maneja la subida y almacenamiento de la imagen en el servidor.
- **Errores y mensajes**: En cada acción, si hay algún error (como datos faltantes o problemas al subir imágenes), se muestran mensajes de error en la vista.
- **Paginación**: Para mostrar los productos de forma eficiente, se usa la librería `Pagerfanta` para la paginación.

Este controlador permite la gestión completa de productos, desde su creación hasta su eliminación, con validación y manejo de imágenes, todo dentro de un sistema de paginación.

# PedidoController

El **`PedidoController`** gestiona las operaciones relacionadas con los pedidos, incluyendo la creación, finalización, visualización y envío de correos de confirmación para los pedidos, así como la actualización del estado de los mismos.

## Métodos principales

### 1. **`__construct()`**
   - Inicializa las instancias de las clases `Pages`, `Pedido` y `CarritoController`.

### 2. **`createPedido()`**
   - Crea un nuevo pedido a partir de los productos en el carrito.
   - Verifica que el usuario esté autenticado y que el carrito no esté vacío.
   - Valida los datos de la dirección de envío y calcula el precio total del pedido.
   - Verifica el stock de los productos y actualiza el inventario en caso de que el pedido sea realizado con éxito.
   - Si el pedido es creado correctamente, limpia el carrito y redirige a la página de pedidos.

### 3. **`completarPedido(int $id)`**
   - Cambia el estado del pedido a "Enviado" una vez completado.
   - Verifica que el usuario esté autenticado y que los productos del pedido existan.
   - Envia un correo de confirmación al usuario con los detalles del pedido.
   - Si el pedido se completa con éxito, redirige a la página de pedidos y vacía el carrito de la sesión.

### 4. **`sendConfirmationEmail(int $pedidoId, $productos)`**
   - Envía un correo electrónico de confirmación al usuario con los detalles de su pedido.
   - Utiliza PHPMailer para enviar un correo con el resumen del pedido y los productos adquiridos.
   - Si ocurre un error al enviar el correo, muestra un mensaje de error.

### 5. **`showPedidos()`**
   - Muestra los pedidos realizados por el usuario o, si el usuario es un administrador, todos los pedidos.
   - Verifica que el usuario esté autenticado antes de acceder a los pedidos.
   - Renderiza la vista `mostrarPedidos` con la lista de pedidos según el rol del usuario.

## Consideraciones adicionales
- **Autenticación**: El controlador asegura que el usuario esté autenticado antes de permitir la creación, modificación o finalización de un pedido.
- **Validación de datos**: Se validan los datos de dirección y se asegura que los productos en el carrito estén disponibles en stock.
- **Envío de correos**: El controlador utiliza PHPMailer para enviar correos electrónicos de confirmación con los detalles del pedido, incluyendo productos, precios y cantidades.
- **Manejo de errores**: En cada acción, si ocurre algún problema (por ejemplo, falta de stock o campos vacíos), se muestran mensajes de error adecuados.

Este controlador permite gestionar todo el ciclo de vida de un pedido, desde su creación hasta su finalización y confirmación por correo, con una gestión adecuada de inventario y errores.

# CategoriaController

El **`CategoriaController`** gestiona las operaciones relacionadas con las categorías, incluyendo la creación, modificación, eliminación y visualización de categorías, así como la visualización de productos pertenecientes a una categoría específica.

## Métodos principales

### 1. **`__construct()`**
   - Inicializa las instancias de las clases `Pages`, `Categoria` y `CarritoController`.

### 2. **`getCategorias()`**
   - Obtiene todas las categorías utilizando el modelo `Categoria`.

### 3. **`createCategoria()`**
   - Muestra el formulario para crear una nueva categoría y maneja la creación de la categoría.
   - Verifica si el usuario está autenticado y valida el nombre de la categoría.
   - Si el nombre de la categoría es válido, la crea en la base de datos y muestra las categorías actualizadas.

### 4. **`showProductosByCategoria(int $id, int $page = 1)`**
   - Muestra los productos de una categoría específica con paginación.
   - Si no hay productos disponibles, muestra un mensaje de error.

### 5. **`showCategorias()`**
   - Muestra todas las categorías disponibles.
   - Si no hay categorías, muestra una página de error.

### 6. **`modificarCategoria(int $id)`**
   - Muestra el formulario para modificar una categoría existente.
   - Verifica si el usuario está autenticado y si la categoría existe.
   - Si la categoría no existe, muestra un error 404.

### 7. **`updateCategoria(int $id)`**
   - Actualiza el nombre de una categoría.
   - Valida el nuevo nombre de la categoría antes de actualizarla en la base de datos.
   - Muestra un mensaje de éxito o error según el resultado de la actualización.

### 8. **`deleteCategoria(int $id)`**
   - Elimina una categoría de la base de datos.
   - Verifica si el usuario está autenticado antes de proceder con la eliminación.
   - Muestra un mensaje de éxito o error según el resultado de la eliminación.

## Consideraciones adicionales
- **Autenticación**: El controlador asegura que el usuario esté autenticado antes de permitir la creación, modificación o eliminación de una categoría.
- **Validación de datos**: Se valida el nombre de la categoría para asegurarse de que solo contenga caracteres válidos.
- **Paginación**: Para mostrar los productos por categoría de forma eficiente, se usa la librería `Pagerfanta` para la paginación.
- **Errores y mensajes**: En cada acción, si hay un error (por ejemplo, si el nombre de la categoría es inválido o si ocurre un problema al eliminar la categoría), se muestra un mensaje de error adecuado.

Este controlador permite gestionar completamente las categorías, desde su creación hasta su eliminación, con validación de datos y una visualización paginada de los productos dentro de las categorías.

# CarritoController

El **`CarritoController`** gestiona las operaciones relacionadas con el carrito de compras, incluyendo la adición, eliminación, visualización de productos, y la actualización de las cantidades en el carrito.

## Métodos principales

### 1. **`__construct()`**
   - Inicializa las dependencias de las clases `Pages`, `Carrito` y `UsuarioController`.

### 2. **`comprobarLogin()`**
   - Verifica si el usuario está autenticado.
   - Si no está logueado, redirige al usuario a la página de login.

### 3. **`addCarrito()`**
   - Añade un producto al carrito de compras.
   - Verifica que los datos sean válidos, si el producto existe y si hay suficiente stock.
   - Si el producto ya está en el carrito, actualiza la cantidad.
   - Guarda el carrito en una cookie durante 3 días y muestra el carrito actualizado.

### 4. **`showCarrito()`**
   - Muestra el contenido del carrito, calculando el total de los productos en el carrito.
   - Renderiza la página del carrito con el total.

### 5. **`containProducto(int $productoId, float $precio)`**
   - Verifica si un producto está en el carrito con el precio correcto.

### 6. **`validarDatosCarrito()`**
   - Valida los datos recibidos para añadir un producto al carrito (producto_id, cantidad, precio, nombre).

### 7. **`updateCantidad(int $cantidad)`**
   - Actualiza la cantidad de un producto en el carrito.
   - Si la cantidad es 0 o menor, elimina el producto del carrito.
   - Si no hay suficiente stock, muestra un error.

### 8. **`addCantidad()`**
   - Aumenta la cantidad de un producto en el carrito en 1.

### 9. **`removeCantidad()`**
   - Reduce la cantidad de un producto en el carrito en 1.

### 10. **`removeProducto()`**
   - Elimina un producto del carrito.
   - Muestra el carrito actualizado después de eliminar el producto.

### 11. **`vaciarCarrito()`**
   - Vacía el carrito en la sesión y elimina la cookie asociada con el carrito.
   - Muestra el carrito vacío.

## Consideraciones adicionales
- **Autenticación**: Antes de permitir cualquier operación en el carrito, se verifica que el usuario esté logueado.
- **Validación de datos**: Se valida que los datos enviados al carrito sean correctos (producto_id, cantidad, precio, nombre).
- **Gestión del carrito**: Los productos se gestionan en una sesión y se guardan en una cookie durante 3 días para persistencia.
- **Errores**: Si hay algún problema (por ejemplo, no hay suficiente stock o el producto no existe), se muestran errores específicos.

Este controlador proporciona una experiencia completa para gestionar el carrito de compras, desde añadir productos hasta vaciarlo, con controles de validación y manejo de errores para garantizar que las operaciones sean coherentes y seguras.

# DashboardController

El **`DashboardController`** se encarga de manejar la lógica para la vista principal del dashboard, mostrando los productos de manera paginada.

## Métodos principales

### 1. **`__construct()`**
   - Inicializa las dependencias necesarias para el controlador.
   - Crea una instancia de la clase `Pages` para manejar la renderización de las vistas.
   - Crea una instancia del `CarritoController` para manejar operaciones relacionadas con el carrito (aunque no se utiliza directamente en este controlador, puede usarse para futuras extensiones).

### 2. **`index()`**
   - Este es el método que maneja la vista principal del dashboard.
   - Obtiene el número de página desde la URL (`$_GET['page']`), con un valor predeterminado de 1 si no se especifica.
   - Establece el número máximo de productos a mostrar por página (9 productos por página).
   - Llama al modelo `Producto` para obtener los productos de forma paginada utilizando la clase `Pagerfanta`.
   - Renderiza la vista `dashboard/inicio`, pasando los productos actuales de la página, el objeto `Pagerfanta` para la paginación y el número de la página actual.

## Consideraciones adicionales
- **Paginación**: La vista maneja la paginación de los productos, mostrando solo una cantidad limitada de productos por página (en este caso, 9 productos).
- **Dependencias**: Aunque el controlador también inicializa `CarritoController`, no se utiliza directamente en el método `index()`. Sin embargo, podría ser útil para futuras funcionalidades relacionadas con el carrito de compras.
- **Visibilidad de productos**: Solo los productos de la página actual se muestran, y los usuarios pueden navegar entre las páginas usando el paginador.

Este controlador proporciona la lógica principal para mostrar una lista de productos en el dashboard de manera eficiente, con soporte para la paginación para manejar grandes cantidades de productos.

# ErrorController

El **`ErrorController`** se encarga de gestionar y mostrar distintos tipos de errores que pueden ocurrir en la aplicación, como errores de recursos no encontrados, solicitudes incorrectas, acceso denegado o errores internos del servidor.

## Métodos principales

### 1. **`showError404(string $mensaje = "Recurso no encontrado.")`**
   - Muestra un error **404 (Recurso no encontrado)**.
   - Acepta un mensaje personalizado o, por defecto, muestra "Recurso no encontrado".
   - Establece el código de respuesta HTTP a 404.
   - Muestra el mensaje de error en la página y detiene la ejecución del script.

### 2. **`accesoDenegado()`**
   - Muestra un mensaje indicando que el acceso está denegado.
   - Utilizado cuando el usuario intenta realizar una acción para la que no tiene permiso.
   - No modifica el código de estado HTTP, simplemente muestra el mensaje.

### 3. **`showError400(string $mensaje = "Solicitud incorrecta.")`**
   - Muestra un error **400 (Solicitud incorrecta)**.
   - Acepta un mensaje personalizado o, por defecto, muestra "Solicitud incorrecta".
   - Establece el código de respuesta HTTP a 400.
   - Muestra el mensaje de error en la página y detiene la ejecución del script.

### 4. **`showError500(string $mensaje)`**
   - Muestra un error **500 (Error interno del servidor)**.
   - Acepta un mensaje que describe el error interno del servidor.
   - Establece el código de respuesta HTTP a 500.
   - Muestra el mensaje de error en la página y detiene la ejecución del script.

## Consideraciones adicionales
- **Mensajes personalizables**: Cada uno de los métodos permite pasar un mensaje personalizado para proporcionar más detalles sobre el error.
- **Código de estado HTTP**: Los métodos establecen el código de respuesta HTTP correspondiente para el tipo de error (404, 400, 500).
- **Finalización del script**: Después de mostrar el mensaje de error, el script se detiene con `exit`, lo que impide que se continúe ejecutando el código en caso de error.

Este controlador es útil para manejar errores de manera centralizada y proporcionar retroalimentación clara a los usuarios en caso de que algo salga mal.

# 4. LIB

# DBConnection

La **`DBConnection`** es una clase que maneja la conexión a la base de datos utilizando **PDO (PHP Data Objects)**. Esta clase facilita la ejecución de consultas SQL y la gestión de resultados de forma segura y eficiente.

## Propiedades

- **`$conexion`**: Almacena la conexión activa a la base de datos mediante **PDO**.
- **`$resultado`**: Almacena el resultado de una consulta ejecutada.

## Métodos principales

### 1. **`__construct()`**
   - Constructor que inicializa la clase con las credenciales de la base de datos (`servidor`, `usuario`, `pass`, `base_datos`).
   - Establece la conexión a la base de datos llamando al método **`conectar()`**.

### 2. **`conectar()`**
   - Establece la conexión a la base de datos usando **PDO** con las credenciales proporcionadas.
   - Configura opciones como la codificación UTF-8, el manejo de errores mediante excepciones y el modo de recuperación de datos.
   - Retorna un objeto **PDO** si la conexión es exitosa, o `null` si ocurre un error.

### 3. **`consulta(string $consultaSQL): bool`**
   - Ejecuta una consulta SQL de solo lectura (como `SELECT`).
   - Retorna `true` si la consulta fue exitosa, o `false` si ocurrió un error.

### 4. **`extraer_registro(): array|false`**
   - Extrae un solo registro del resultado de la consulta.
   - Retorna el registro como un array o `false` si no hay más resultados.

### 5. **`extraer_todos(): array`**
   - Extrae todos los registros del resultado de la consulta.
   - Retorna un array con los registros o un array vacío si no hay resultados.

### 6. **`filasAfectadas(): int`**
   - Retorna la cantidad de filas afectadas por la última consulta ejecutada.

### 7. **`close()`**
   - Cierra la conexión a la base de datos y limpia el resultado de la consulta.

### 8. **`prepare(string $sql): ?\PDOStatement`**
   - Prepara una consulta SQL para ser ejecutada de manera segura mediante una sentencia preparada.
   - Retorna un objeto **PDOStatement** si la preparación es exitosa, o `null` si la conexión no está disponible.

### 9. **`getConnection(): ?PDO`**
   - Retorna la conexión **PDO** actual.

### 10. **`lastInsertId(): ?string`**
   - Retorna el último ID insertado en la base de datos después de una operación de inserción, o `null` si no hay conexión.

## Consideraciones adicionales
- **Manejo de errores**: La clase maneja errores de conexión mediante excepciones, registrándolos en el log de errores si ocurre un problema al intentar conectarse.
- **Seguridad**: La clase utiliza sentencias preparadas para proteger contra ataques de **inyección SQL**.
- **Flexibilidad**: Permite ejecutar consultas de solo lectura o consultas seguras con sentencias preparadas.

Esta clase es fundamental para interactuar con la base de datos en la aplicación, proporcionando métodos sencillos y seguros para ejecutar consultas y manejar resultados.

# Pages

La clase **`Pages`** se encarga de la renderización de vistas en la aplicación. Permite cargar vistas con parámetros opcionales y manejar la inclusión del **header** y **footer** de manera flexible.

## Métodos principales

### 1. **`render(string $pageName, array $params = [], bool $loadHeader = true, bool $loadFooter = true): void`**
   - **Descripción**: Este método renderiza una vista específica con parámetros opcionales. También permite controlar si se deben cargar el **header** y el **footer**.
   - **Parámetros**:
     - **`$pageName`** (string): El nombre de la vista que se desea cargar.
     - **`$params`** (array|null): Parámetros opcionales que se pasan a la vista (por ejemplo, datos que se mostrarán).
     - **`$loadHeader`** (bool): Si es `true`, carga el archivo de encabezado (`header.php`).
     - **`$loadFooter`** (bool): Si es `true`, carga el archivo de pie de página (`footer.php`).
   - **Funcionamiento**:
     - Establece la ruta base de las vistas en el directorio `Views/`.
     - Verifica si la vista solicitada existe. Si no es así, muestra un mensaje de error.
     - Si la vista es de registro de usuario, omite la carga del **header** y **footer**.
     - Carga el **header** y **footer** si los parámetros correspondientes son `true`.
     - Si se pasan parámetros, se asignan como variables locales a la vista.
     - Finalmente, incluye el archivo de la vista principal.

### 2. **`includeFile(string $file): void`**
   - **Descripción**: Este método incluye un archivo si existe. Si el archivo no se encuentra, muestra un mensaje de error.
   - **Parámetros**:
     - **`$file`** (string): La ruta del archivo que se desea incluir.
   - **Funcionamiento**:
     - Verifica si el archivo existe antes de incluirlo usando `require_once`.
     - Si el archivo no se encuentra, muestra un mensaje de error con detalles.

## Características destacadas

- **Flexibilidad**: Permite cargar vistas con o sin **header** y **footer**, lo cual es útil para páginas como el registro de usuario.
- **Manejo de errores**: Si una vista o un archivo no existe, se muestra un mensaje claro que facilita el diagnóstico.
- **Parámetros dinámicos**: Los parámetros pasados a la vista se asignan automáticamente a variables locales dentro de la vista.
- **Inclusión de archivos seguros**: Asegura que los archivos se incluyan solo si existen, previniendo errores fatales en la aplicación.

Esta clase es esencial para la renderización de páginas, manteniendo una estructura coherente y controlada en la carga de las vistas dentro de la aplicación.

## Router

La clase **`Router`** es responsable de gestionar las rutas de la aplicación y dirigir las solicitudes HTTP a los controladores adecuados. Permite registrar rutas y sus métodos asociados, y luego procesa las solicitudes entrantes para ejecutar el controlador correspondiente.

## Métodos principales

### 1. **`add(string $method, string $action, callable $controller): void`**
   - **Descripción**: Este método permite registrar nuevas rutas en el enrutador, asociando un método HTTP (como `GET`, `POST`) con una acción específica y su controlador correspondiente.
   - **Parámetros**:
     - **`$method`** (string): El método HTTP de la ruta (por ejemplo, `GET`, `POST`).
     - **`$action`** (string): La acción o ruta que se desea registrar (por ejemplo, `/categoria/mostrar`).
     - **`$controller`** (callable): La función del controlador que se ejecutará cuando se acceda a la ruta.
   - **Funcionamiento**: 
     - Elimina las barras inclinadas al principio y final de la acción.
     - Registra la ruta en un arreglo estático, agrupada por el método HTTP.

### 2. **`dispatch(): void`**
   - **Descripción**: Este método procesa la solicitud entrante, obtiene la ruta y el método HTTP, y llama al controlador correspondiente si la ruta está registrada.
   - **Funcionamiento**:
     - Obtiene el método HTTP y la URI completa de la solicitud.
     - Remueve cualquier prefijo de la URL (como la ruta base de la aplicación).
     - Si no hay sesión activa pero existe una cookie con el correo del usuario, intenta iniciar sesión automáticamente basándose en la cookie.
     - Si la ruta solicitada está registrada en el enrutador, ejecuta el controlador asociado usando `call_user_func`.
     - Si la ruta no está registrada, muestra un mensaje de error `404` indicando que la ruta no fue encontrada.

## Características destacadas

- **Gestión dinámica de rutas**: Permite agregar nuevas rutas de manera flexible y asociarlas con controladores específicos.
- **Soporte para métodos HTTP**: Registra rutas tanto para `GET`, `POST`, y otros métodos HTTP, lo que facilita la gestión de diferentes tipos de solicitudes.
- **Autenticación automática**: Si un usuario no tiene sesión activa, pero se encuentra una cookie con su correo electrónico, se intenta iniciar sesión automáticamente, lo que mejora la experiencia del usuario.
- **Manejo de errores**: Si se accede a una ruta no registrada, se devuelve un error `404`.

Esta clase es fundamental para el enrutamiento en la aplicación, dirigiendo correctamente las solicitudes a los controladores adecuados según las rutas definidas.


# 5. Routes

La clase **`Routes`** gestiona todas las rutas de la aplicación, asociando cada ruta con un controlador específico. Cada acción o endpoint del sistema está definido aquí, permitiendo que el enrutador sepa qué controlador debe ejecutar dependiendo de la solicitud del usuario.

## Método principal

### 1. **`index(): void`**
   - **Descripción**: Este es el método que define todas las rutas de la aplicación y las asocia con sus respectivos controladores. Utiliza la clase **`Router`** para registrar las rutas, especificando el método HTTP y la ruta correspondiente.
   - **Funcionamiento**:
     - **Dashboard**: Define rutas para la página de inicio y la paginación del dashboard.
     - **Usuario**: Incluye rutas para el registro de usuarios, login, logout, y modificación de datos del usuario.
     - **Categoría**: Permite la creación, modificación, eliminación y visualización de categorías de productos.
     - **Producto**: Gestiona rutas para crear, modificar, eliminar, y listar productos, incluyendo su visualización en categorías específicas y con paginación.
     - **Carrito**: Registra rutas para agregar productos al carrito, mostrar el contenido del carrito, y gestionar la cantidad o eliminar productos.
     - **Pedido**: Define rutas para crear pedidos, mostrar pedidos existentes, completar un pedido y gestionar las acciones de los pedidos.

### Función de las rutas
- **Rutas de Dashboard**: Acceso a la página principal y a páginas paginadas.
- **Rutas de Usuario**: Permite registro, login, logout y modificación de datos.
- **Rutas de Categorías**: Crear, modificar, eliminar y listar categorías.
- **Rutas de Productos**: Gestionar productos (crear, modificar, eliminar, mostrar por categoría).
- **Rutas de Carrito**: Añadir productos al carrito, mostrar contenido, eliminar productos, y gestionar cantidades.
- **Rutas de Pedidos**: Crear y mostrar pedidos, completar pedidos.

Cada ruta se asocia a una función específica de su controlador correspondiente, lo que permite una gestión eficaz de las acciones en la aplicación.

## Características destacadas
- **Enrutamiento flexible**: La clase permite registrar rutas con diferentes métodos HTTP (GET, POST, etc.).
- **Modularidad**: Cada acción relacionada con categorías, productos, usuarios, carritos y pedidos está separada y gestionada por su controlador respectivo.
- **Gestión de sesiones y cookies**: Aunque no se menciona explícitamente, el enrutador puede estar vinculado con la gestión de sesiones y cookies para manejar la autenticación del usuario.
- **Rutas dinámicas**: Muchas rutas incluyen parámetros dinámicos (como `id` o `page`), que permiten una navegación más flexible.

Este enfoque asegura que cada ruta sea manejada de forma específica, modular y eficiente, permitiendo una estructura limpia y mantenible de las rutas en la aplicación.

# 6. UTILS

La clase **`Utils`** contiene métodos estáticos utilizados para realizar operaciones generales y utilitarias en la aplicación.

## Métodos

### 1. **`deleteSession(string $name): void`**
   - **Descripción**: Este método se utiliza para eliminar una variable de sesión especificada por su nombre.
   - **Parámetros**:
     - `$name`: El nombre de la variable de sesión que se desea eliminar.
   - **Funcionamiento**: 
     - Verifica si existe una variable de sesión con el nombre proporcionado (`$name`). 
     - Si la variable de sesión está definida, la elimina utilizando `unset()`, eliminando así la sesión especificada.
   - **Uso**: Este método es útil cuando se necesita limpiar una sesión, por ejemplo, al cerrar sesión de un usuario.

## Características destacadas
- **Métodos estáticos**: Los métodos son estáticos, por lo que no es necesario crear una instancia de la clase para utilizarlos.
- **Operación sencilla**: Se enfoca en una operación sencilla pero común en la gestión de sesiones en aplicaciones web.

La clase **`Utils`** proporciona funcionalidad básica pero útil para la gestión de sesiones, contribuyendo a la limpieza y mantenimiento del estado de la sesión en la aplicación.

# 7. VIEWS

# dashboard

## inicio

La vista de inicio es la página principal de la tienda online. A continuación se describe brevemente su estructura:

- **Encabezado**: 
  - Un título de bienvenida "Bienvenido a nuestra tienda" en color blanco y centrado.

- **Menú de Categorías**:
  - Navegación superior con una barra de menú que muestra todas las categorías disponibles. Cada categoría es un enlace que dirige a la vista de productos de esa categoría.

- **Listado de Productos**:
  - Los productos se muestran en tarjetas con el siguiente formato:
    - Imagen del producto.
    - Nombre del producto como título.
    - Descripción breve del producto.
    - Precio en color amarillo.
    - Un formulario para agregar el producto al carrito con:
      - Campo para seleccionar la cantidad.
      - Botón para añadir al carrito, que está deshabilitado si el usuario no ha iniciado sesión.

- **Paginación**:
  - Si hay más de una página de productos, se muestra un sistema de paginación con botones para navegar entre páginas.

- **Estilo**:
  - Fondo oscuro (negro) con texto blanco.
  - Diseño responsivo usando Bootstrap, adaptándose bien a diferentes tamaños de pantalla.

Esta página es la puerta de entrada a la tienda, mostrando tanto las categorías como los productos disponibles de manera clara y accesible.

![Inicio](https://files.catbox.moe/wmuyew.png "Inicio")

# layout

## header

La vista del encabezado (header) es la parte superior de la página donde se incluye la barra de navegación. A continuación, se describen sus elementos principales:

## Elementos del Header:

1. **Logo de la Tienda**:
   - En el lado izquierdo de la barra de navegación, se muestra el logo de la tienda **"Car Shop"**. Al hacer clic en el logo, se redirige a la página principal.

2. **Navegación**:
   - **Usuarios no autenticados**:
     - Enlaces para **Iniciar sesión** y **Registrarse**.
   - **Usuarios autenticados**:
     - Si el usuario tiene el rol de **admin**, se muestran enlaces para gestionar pedidos, productos, categorías y registrar usuarios.
     - Si el usuario tiene el rol de **cliente**, se muestran enlaces para **Mis Pedidos** y un icono de carrito de compras.
   - **Cerrar sesión**:
     - Un enlace para cerrar sesión disponible para todos los usuarios autenticados.

3. **Información de Usuario**:
   - Si el usuario está autenticado, se muestra su nombre y apellidos, con un enlace para modificar sus datos.

4. **Estilo**:
   - Fondo oscuro en el `header` con texto en blanco.
   - El nombre de la tienda y los enlaces de la barra de navegación tienen un color morado vibrante (`#B52BD8`) que cambia al pasar el mouse sobre ellos.
   - Utiliza **Bootstrap** para la estructura de la barra de navegación y **FontAwesome** para los iconos (como el carrito de compras).
   - La barra es responsiva, adaptándose a pantallas pequeñas con el menú desplegable.

Este header proporciona acceso fácil y directo a las funcionalidades principales de la tienda según el rol del usuario (cliente o administrador).

![Header](https://files.catbox.moe/bjdjmh.png "Header")

![Header](https://files.catbox.moe/gnlifj.png "Header")

![Header](https://files.catbox.moe/o0j55y.png "Header")

## footer

La vista del footer es la sección inferior de la página que proporciona información adicional y enlaces relevantes para los usuarios. A continuación, se describen sus elementos principales:

## Elementos del Footer:

1. **Sobre Nosotros**:
   - Un pequeño bloque que describe la tienda en línea y su compromiso con ofrecer los mejores productos al mejor precio.

2. **Enlaces Rápidos**:
   - Enlaces de acceso rápido a la página de inicio y al carrito de compras. Estos enlaces facilitan la navegación para los usuarios.

3. **Redes Sociales**:
   - Enlaces a las redes sociales de la tienda, representados con iconos de **Facebook**, **Twitter**, **Instagram** y **LinkedIn**. Estos iconos utilizan **Bootstrap Icons** y cambian de color al pasar el cursor.

4. **Derechos Reservados**:
   - Un mensaje de derechos de autor con el año actual, indicando que todos los derechos están reservados para la tienda.

5. **Estilo**:
   - Fondo negro con texto blanco para una apariencia coherente con el diseño general de la página.
   - Los enlaces y los iconos de redes sociales cambian de color a un morado brillante (`#B52BD8`) cuando el usuario pasa el cursor sobre ellos, lo que proporciona interactividad.
   - La estructura está basada en **Bootstrap** y usa clases como `container`, `row`, y `col-md-4` para organizar el contenido en una cuadrícula responsive.

Este footer ofrece una forma accesible y funcional para que los usuarios encuentren información adicional, accedan a enlaces importantes y se conecten con las redes sociales de la tienda.

![Footer](https://files.catbox.moe/8mkel0.png "Footer")

# usuario

## login

La vista de login permite a los usuarios iniciar sesión en la tienda en línea. A continuación se describen sus elementos principales:

## Elementos del Login:

1. **Formulario de Inicio de Sesión**:
   - El formulario solicita dos campos:
     - **Email**: Campo de texto para ingresar el correo electrónico.
     - **Contraseña**: Campo de texto para ingresar la contraseña.
   - También se incluye una opción de **"Recuérdame"** mediante un checkbox.

2. **Errores de Autenticación**:
   - Si hay errores en el inicio de sesión, se muestran como mensajes de alerta (`alert-danger`) debajo del formulario.

3. **Botón de Envío**:
   - Un botón de inicio de sesión con un diseño de **gradiente** en tonos morados y texto en color negro.
   - El botón tiene un estilo personalizado y ocupa todo el ancho disponible del formulario.

4. **Enlace de Registro**:
   - Un enlace debajo del formulario que permite al usuario registrarse si aún no tiene una cuenta. Este enlace está estilizado en blanco y se subraya al pasar el cursor.

5. **Estilo**:
   - Fondo oscuro en la página y el contenedor del formulario con un color de fondo más oscuro, para generar un contraste visual.
   - Campos de entrada y botones con bordes y texto claros, además de un enfoque visual atractivo en el botón de inicio de sesión.
   - El formulario se centra en la página utilizando **flexbox**, con un diseño responsivo y optimizado para una experiencia de usuario cómoda.

Esta vista proporciona una interfaz limpia y clara para que los usuarios inicien sesión en la tienda en línea, con validación de errores y opciones para registrarse si no tienen cuenta.

![Login](https://files.catbox.moe/011ja7.png "Login")

## registro

La vista de registro permite a los usuarios crear una nueva cuenta en la tienda en línea. A continuación se describen sus elementos principales:

## Elementos del Registro:

1. **Formulario de Registro**:
   - El formulario solicita los siguientes campos:
     - **Nombre**: Campo de texto para el nombre del usuario.
     - **Apellidos**: Campo de texto para los apellidos del usuario.
     - **Email**: Campo de texto para ingresar el correo electrónico.
     - **Contraseña**: Campo de texto para ingresar la contraseña.
     - **Rol**: Un campo de selección para elegir el rol del usuario (por defecto es "Usuario" y solo los administradores pueden asignar el rol de "Administrador").
   - El formulario se envía mediante un **POST** a la acción de registro.

2. **Mensajes de Error y Éxito**:
   - Si el registro se ha completado correctamente, se muestra un mensaje de éxito (`alert-success`).
   - Si hubo un error en el proceso de registro, se muestra un mensaje de error (`alert-danger`).
   - Si existen errores de validación en los campos del formulario, se muestran debajo del formulario.

3. **Botón de Envío**:
   - Un botón de registro con un diseño de **gradiente** en tonos morados y texto en color negro.
   - El botón tiene un estilo personalizado y ocupa todo el ancho disponible del formulario.

4. **Enlace de Login**:
   - Un enlace debajo del formulario que permite al usuario ir a la página de inicio de sesión si ya tiene una cuenta. Este enlace está estilizado en blanco y se subraya al pasar el cursor.

5. **Estilo**:
   - Fondo oscuro en la página y el contenedor del formulario con un color de fondo más oscuro, para generar un contraste visual.
   - Campos de entrada y botones con bordes y texto claros, además de un enfoque visual atractivo en el botón de registro.
   - El formulario se centra en la página utilizando **flexbox**, con un diseño responsivo y optimizado para una experiencia de usuario cómoda.

Esta vista proporciona una interfaz clara y sencilla para que los usuarios se registren en la tienda en línea, con validación de errores y la opción de iniciar sesión si ya tienen cuenta.

![Registro](https://files.catbox.moe/nd3v4c.png "Registro")

## modificarDatos

La vista para modificar los datos de usuario permite que los usuarios actualicen su información personal en el sistema. A continuación se detallan los elementos clave de esta vista:

## Elementos Principales:

1. **Encabezado**:
   - Título: "Modificar Datos de Usuario", centrado y con un estilo de texto claro.

2. **Mensajes de Éxito o Error**:
   - Si el proceso de modificación es exitoso, se muestra un mensaje de éxito (`alert-success`).
   - Si hay errores, se muestran dentro de un mensaje de error (`alert-danger`).
   - Los errores específicos, si los hay, se listan debajo del formulario, mostrando un listado de los problemas detectados.

3. **Formulario para Modificar Datos**:
   - El formulario permite modificar los siguientes campos:
     - **Nombre**: Campo de texto para modificar el nombre del usuario.
     - **Apellidos**: Campo de texto para modificar los apellidos del usuario.
     - **Email**: Campo de texto para modificar el correo electrónico del usuario.
     - **Contraseña**: Campo de texto para modificar la contraseña (opcional).
     - **Rol**: Solo visible para administradores, permitiendo seleccionar entre "Usuario" o "Administrador". El valor se selecciona según el rol actual del usuario.

4. **Botón de Envío**:
   - Un botón para guardar los cambios, centrado en la pantalla con un estilo llamativo.

5. **Estilo**:
   - El formulario está contenido dentro de una tarjeta con un fondo oscuro y texto claro, para mantener una apariencia coherente con el diseño general de la página.
   - Los campos del formulario tienen un fondo gris oscuro y bordes claros, asegurando la legibilidad y coherencia con el diseño.
   - La vista está diseñada de manera responsiva, centrando el formulario en la pantalla.

Esta vista proporciona una manera simple y clara para que los usuarios (y administradores, si corresponde) modifiquen sus datos de cuenta, con mensajes de retroalimentación para cada acción.

![Modificar Datos](https://files.catbox.moe/6ngg0c.png "Modificar Datos")

![Modificar Datos](https://files.catbox.moe/sjin0o.png "Modificar Datos")

# producto

## lista

La vista de lista de productos por categoría muestra los productos disponibles en una categoría específica. A continuación se describen los elementos clave de esta vista:

## Elementos Principales:

1. **Encabezado**:
   - Título: "Productos por Categoría", centrado con un estilo de texto blanco sobre fondo oscuro.

2. **Barra de Navegación de Categorías**:
   - Se muestra una lista de categorías disponibles que permite al usuario filtrar productos por categoría. Cada categoría está representada por un enlace que redirige a la vista de productos de esa categoría.

3. **Listado de Productos**:
   - Los productos se presentan en tarjetas dentro de una cuadrícula (3 productos por fila en pantallas medianas). 
   - Cada tarjeta incluye:
     - **Imagen del Producto**: Se muestra una imagen del producto con un límite de altura de 200px y ajustada para mantener una relación de aspecto adecuada.
     - **Nombre del Producto**: El nombre del producto se muestra en la parte superior de la tarjeta.
     - **Descripción del Producto**: Una breve descripción del producto.
     - **Precio**: El precio del producto se resalta en color amarillo.
     - **Cantidad y Botón de Añadir al Carrito**: El usuario puede seleccionar la cantidad del producto y añadirlo al carrito. El botón se desactiva si el usuario no está logueado.
   - Si el usuario no está logueado, se muestra un mensaje indicando que debe iniciar sesión para comprar.

4. **Paginación**:
   - Si hay más de una página de productos, se incluye un sistema de paginación al final de la lista de productos.
   - Los usuarios pueden navegar entre páginas de productos utilizando enlaces numerados y botones para avanzar o retroceder.

5. **Estilo**:
   - La página tiene un fondo negro y texto blanco para mantener la coherencia con el tema oscuro.
   - Los productos se muestran en tarjetas con un diseño atractivo, y se asegura una buena usabilidad en dispositivos móviles.
   
Esta vista permite a los usuarios explorar los productos de manera eficiente y agregar artículos a su carrito según la categoría seleccionada.

![Lista](https://files.catbox.moe/4r6uf9.png "Lista")

## crearProducto

La vista de crear producto permite al administrador agregar nuevos productos al sistema. A continuación se describen los elementos clave de esta vista:

## Elementos Principales:

1. **Encabezado**:
   - Título: "Crear Producto", centrado en la parte superior de la página.

2. **Mensajes de Error o Éxito**:
   - Si hay errores de validación, se muestran en un bloque de alerta con fondo rojo.
   - Si la creación del producto es exitosa, se muestra un mensaje de éxito en un bloque verde.

3. **Formulario de Creación de Producto**:
   - El formulario contiene varios campos para ingresar los detalles del producto:
     - **Nombre**: Campo de texto para el nombre del producto.
     - **Descripción**: Campo de texto para proporcionar una breve descripción del producto.
     - **Categoría**: Menú desplegable para seleccionar la categoría del producto (con categorías obtenidas de la base de datos).
     - **Precio**: Campo numérico para ingresar el precio del producto en euros.
     - **Stock**: Campo numérico para ingresar la cantidad disponible en stock.
     - **Oferta**: Campo numérico para definir un descuento porcentual (opcional).
     - **Fecha**: Campo de fecha con la fecha actual por defecto.
     - **Imagen**: Campo para subir una imagen del producto (opcional).

4. **Botones**:
   - **Crear Producto**: Botón para enviar el formulario y crear el producto.
   - **Volver**: Enlace que lleva al usuario a la vista de gestión de productos.

5. **Estilo**:
   - El diseño utiliza Bootstrap para un formato responsive y fácil de usar.
   - Los campos del formulario tienen un estilo limpio y consistente, con etiquetas claras para cada entrada.

Esta vista permite a los administradores crear nuevos productos fácilmente, asegurándose de que toda la información relevante del producto esté completa antes de ser añadida al sistema.

![Crear Producto](https://files.catbox.moe/71qd4s.png "Crear Producto")

## gestionarProductos

La vista para gestionar productos permite a los administradores visualizar, modificar y eliminar productos desde una interfaz de usuario amigable. A continuación, se describen los componentes principales de esta vista:

## Elementos Principales:

1. **Encabezado**:
   - Título: "Gestionar Productos", centrado en la parte superior de la página.

2. **Mensajes de Error o Éxito**:
   - Si hay un mensaje de éxito, se muestra en un bloque de alerta verde.
   - Si ocurren errores, se muestran en un bloque de alerta roja.

3. **Listado de Productos**:
   - Se muestra un **listado de productos** en tarjetas (3 productos por fila en dispositivos más grandes).
   - Cada tarjeta contiene:
     - **Imagen**: Una imagen del producto con un tamaño adecuado.
     - **Nombre**: El nombre del producto.
     - **Descripción**: Una breve descripción del producto.
     - **Precio**: El precio del producto.
     - **Botones**:
       - **Modificar**: Enlace para editar el producto.
       - **Eliminar**: Enlace para eliminar el producto.

4. **Paginación**:
   - Si hay más productos de los que se pueden mostrar en una sola página, se muestra una **paginación**.
   - Los botones de paginación permiten navegar entre las páginas de productos.

5. **Estilo**:
   - La vista utiliza **Bootstrap** para un diseño responsive y moderno.
   - Las tarjetas de productos tienen un diseño consistente con fondo oscuro, texto claro y botones de acción destacados.

Esta vista proporciona a los administradores las herramientas necesarias para gestionar los productos de manera eficiente, con la posibilidad de realizar modificaciones y eliminaciones rápidamente.

![Gestionar Productos](https://files.catbox.moe/qxjwvu.png "Gestionar Productos")

## modificar

La vista para modificar un producto permite a los administradores actualizar la información de un producto ya existente. A continuación, se describe la estructura de la vista:

## Elementos Principales:

1. **Encabezado**:
   - Título: "Modificar Producto", centrado en la parte superior de la página.

2. **Mensajes de Error o Éxito**:
   - Si hay un mensaje de éxito, se muestra en un bloque de alerta verde.
   - Si hay errores, se muestra en un bloque de alerta roja, donde se detallan los problemas con el formulario.

3. **Formulario de Modificación**:
   - El formulario permite actualizar los siguientes campos:
     - **Nombre**: Campo de texto para el nombre del producto.
     - **Descripción**: Campo de texto largo (textarea) para la descripción del producto.
     - **Categoría**: Menú desplegable con las categorías disponibles, eligiendo la categoría actual del producto.
     - **Precio**: Campo numérico para el precio del producto.
     - **Stock**: Campo numérico para definir la cantidad disponible en stock.
     - **Oferta**: Campo numérico para ingresar un porcentaje de descuento (opcional).
     - **Fecha**: Campo de fecha para definir la fecha del producto, con un valor predeterminado si no se especifica.
     - **Imagen**: Campo para subir una nueva imagen, con la opción de ver la imagen actual si ya existe.
   
4. **Acciones**:
   - **Botón de Enviar**: Un botón para guardar los cambios, que envía el formulario.
   - **Botón de Volver**: Un enlace para regresar a la vista de gestión de productos sin guardar cambios.

5. **Estilo**:
   - La vista usa **Bootstrap** para un diseño responsive.
   - Los campos del formulario están bien estructurados para facilitar la edición del producto.
   - Si ya existe una imagen asociada al producto, esta se muestra debajo del campo de carga de imágenes.

6. **Producto No Encontrado**:
   - Si el producto no es encontrado en la base de datos, se muestra un mensaje de advertencia indicando que el producto no existe.

Esta vista proporciona una interfaz simple y eficiente para que los administradores modifiquen la información de los productos en el sistema.

![Modificar](https://files.catbox.moe/r8d54c.png "Modificar")

# categoria

## mostrarCategorias

La vista para mostrar las categorías permite a los administradores ver una lista de las categorías disponibles en el sistema. Aquí se detalla la estructura principal de la vista:

## Elementos Principales:

1. **Encabezado**:
   - Título: "Listado de Categorías", centrado en la parte superior de la página.

2. **Mensajes de Error o Éxito**:
   - Si hay un mensaje de éxito, se muestra en un bloque de alerta verde.
   - Si hay errores, se muestran en un bloque de alerta roja con los detalles del error.

3. **Lista de Categorías**:
   - Se presenta una lista de categorías en un **`<ul>`** con **`<li>`** para cada categoría.
   - Cada categoría incluye el nombre de la categoría y dos botones:
     - **Modificar**: Botón para editar la categoría, redirigiendo a la página de modificación.
     - **Eliminar**: Botón para eliminar la categoría, con un formulario que envía la solicitud de eliminación.

4. **Estilo**:
   - Utiliza **Bootstrap** para la interfaz de usuario.
   - La lista de categorías está bien organizada con botones pequeños y alineados para facilitar las acciones de modificar o eliminar.

5. **Mensajes de Lista Vacía**:
   - Si no hay categorías disponibles, se muestra un mensaje dentro de la lista que indica: "No hay categorías disponibles."

Esta vista proporciona una manera simple y clara de visualizar y gestionar las categorías dentro del sistema.

![Mostrar Categorías](https://files.catbox.moe/4xag9a.png "Mostrar Categorías")

## crearCategoria

La vista para crear una nueva categoría permite a los administradores agregar categorías al sistema. Aquí se detalla la estructura principal de la vista:

## Elementos Principales:

1. **Encabezado**:
   - Título: "Crear Nueva Categoría", centrado en la parte superior de la página.

2. **Mensajes de Error o Éxito**:
   - Si hay un mensaje de éxito, se muestra en un bloque de alerta verde.
   - Si hay errores, se muestran en un bloque de alerta roja, con los detalles de cada error.

3. **Formulario de Creación de Categoría**:
   - El formulario permite al usuario ingresar el nombre de la categoría.
   - El campo de entrada tiene una etiqueta que indica "Nombre de la categoría".
   - El formulario envía los datos al controlador **`Categoria/crearCategoria/`** mediante el método **POST**.

4. **Botón de Envío**:
   - Un botón de **"Crear Categoría"** centrado debajo del campo de entrada.

5. **Estilo**:
   - Utiliza **Bootstrap** para una apariencia limpia y funcional.
   - El formulario tiene un diseño centrado con un máximo de 600px de ancho, lo que lo hace fácil de usar.

Esta vista permite a los administradores crear categorías de manera eficiente y con una interfaz sencilla.

![Crear Categoría](https://files.catbox.moe/ruqoyf.png "Crear Categoría")

## modificar

La vista de modificación de categoría permite a los administradores actualizar el nombre de una categoría existente.

## Elementos Principales:

1. **Encabezado**:
   - Título centrado: **"Actualizar Categoría"**.

2. **Mensajes de Estado**:
   - Si la operación es exitosa, se muestra un mensaje en un **alerta verde**.
   - Si hay errores, se listan en un **alerta roja**.

3. **Formulario de Edición**:
   - Campo de entrada para modificar el nombre de la categoría.
   - Se completa automáticamente con el nombre actual de la categoría.
   - Se envían los datos al controlador **`Categoria/actualizarCategoria`** con el ID de la categoría.

4. **Botón de Envío**:
   - Un botón **"Actualizar"**, centrado.

5. **Estilo**:
   - Se usa **Bootstrap** para la maquetación.
   - El formulario está centrado con un ancho máximo de **600px** para una mejor experiencia de usuario.

Esta vista proporciona una interfaz sencilla y eficiente para modificar categorías en el sistema.

![Modificar](https://files.catbox.moe/rkt1d3.png "Modificar")

# pedidos

## mostrarPedidos

La vista de listado de pedidos permite visualizar los pedidos realizados en el sistema.

## Elementos Principales:

1. **Encabezado**:
   - Título centrado: **"Listado de Pedidos"**.

2. **Listado de Pedidos**:
   - Cada pedido se muestra en una **tarjeta oscura** con bordes y sombras para mejor visualización.
   - Datos clave del pedido:
     - **ID**, **Provincia**, **Localidad**, **Dirección**, **Coste**, **Estado**, **Fecha** y **Hora**.

3. **Opciones de Gestión**:
   - Si el pedido **no está enviado** y el usuario es **admin**, se muestra un botón **"Marcar como Enviado"**.
   - Si el pedido ya fue enviado, se indica con un **mensaje en verde**.

4. **Mensajes de Estado**:
   - Si no hay pedidos, se muestra un **mensaje centrado** informando que no hay registros disponibles.

5. **Diseño y Estilo**:
   - Se usa **Bootstrap** para una distribución clara.
   - Cada pedido ocupa **una fila completa** (`col-12`) para mayor legibilidad.

Esta vista proporciona una forma ordenada y clara de administrar los pedidos dentro del sistema.

![Mostrar Pedidos](https://files.catbox.moe/6empm0.png "Mostrar Pedidos")

![Mostrar Pedidos](https://files.catbox.moe/ebwury.png "Mostrar Pedidos")

## formularioPago

La vista del **formulario de pago** permite a los usuarios ingresar su información para realizar un pedido.

## Elementos Principales:

1. **Encabezado**:
   - Título centrado: **"Formulario de Pago"**.

2. **Formulario de Datos**:
   - Se encuentra dentro de una **tarjeta oscura con sombras** para mejorar la visibilidad.
   - Campos requeridos:
     - **Provincia**, **Localidad** y **Dirección**.
   - Cada campo utiliza **estilos oscuros y bordes claros** para mantener la coherencia visual.

3. **Botón de Envío**:
   - Botón centrado con diseño **amarillo y texto oscuro** con negrita: **"Realizar Pedido"**.

4. **Estilo y Diseño**:
   - Usa **Bootstrap** para una apariencia moderna y adaptable.
   - Formulario dentro de una **columna centrada (col-md-6)**.

5. **Extra**:
   - **FontAwesome** se incluye para futuros iconos, aunque no se usa en esta vista.

Este formulario proporciona una experiencia clara y sencilla para que los usuarios completen su compra.

![Formulario Pago](https://files.catbox.moe/wzp1u0.png "Formulario Pago")

# carrito 

## mostrarCarrito

La vista del **carrito de compras** permite a los usuarios visualizar y gestionar los productos añadidos antes de realizar una compra.

## Elementos Principales:

1. **Encabezado**:
   - Título **"Carrito de Compras"** centrado.

2. **Carga de Datos**:
   - Se recupera la información del carrito desde una **cookie** y se almacena en **$_SESSION['carrito']**.

3. **Listado de Productos**:
   - Se muestra cada producto en una **tarjeta (card)** con:
     - **Imagen del producto**.
     - **Nombre y cantidad** en el carrito.
     - **Subtotal calculado** (precio * cantidad).
     - **Mensaje sobre stock disponible**.

4. **Opciones para Modificar el Carrito**:
   - Botón **(+)** para **aumentar la cantidad** (deshabilitado si no hay más stock).
   - Botón **(-)** para **disminuir la cantidad**.
   - Botón **"Eliminar"** para **quitar el producto** completamente.

5. **Total del Carrito y Acciones**:
   - Se muestra el **total a pagar**.
   - Botón para **vaciar el carrito**.
   - Botón para **realizar el pedido**.

6. **Carrito Vacío**:
   - Mensaje indicando que **no hay productos** si el carrito está vacío.

## Estilo y Diseño:
- Usa **Bootstrap** para una interfaz responsiva.
- Tarjetas con **fondo oscuro y bordes claros** para resaltar los productos.
- **Distribución flexible** con **diseño en cuadrícula (grid)**.

Esta vista proporciona una forma intuitiva y funcional para gestionar productos antes de la compra.

![Mostrar Carrito](https://files.catbox.moe/46bkm2.png "Mostrar Carrito")

# error

La vista de **error** muestra un mensaje cuando ocurre un problema en la aplicación.

## Elementos Principales:

1. **Encabezado**:
   - Título **"Error"** en rojo para destacar el problema.

2. **Mensaje de Error**:
   - Indica que **ha ocurrido un error** y se sugiere intentarlo más tarde.

3. **Botón de Redirección**:
   - Enlace para **volver a la página de inicio** y salir del estado de error.

## Estilo y Diseño:
- Usa **Bootstrap** para una presentación limpia.
- **Fondo oscuro con texto claro** para mejorar la legibilidad.
- **Diseño centrado** para una mejor experiencia de usuario.

Esta vista proporciona una forma clara y sencilla de manejar errores en la aplicación.
