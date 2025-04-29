<template>
    <div class="app-container bg-gray-100 min-h-screen p-10">
        <!-- Menú lateral -->
        <aside class="sidebar">
            <h2 class="logo">MiApp</h2>
            <nav>
                <ul>
                    <li><router-link to="/sms">Enviar SMS</router-link></li>
                    <li><router-link to="/sms/sms-logs">Historial</router-link></li>
                    <li><router-link to="/sms/sms-stats">Estadísticas</router-link></li>
                    <li><router-link to="/sms/settings">Configuración</router-link></li>
                </ul>
            </nav>
        </aside>
        <!-- Contenedor principal -->
        <div class="container">
            <router-view></router-view> 
        </div>

        
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            newPhone: '', // Número temporal para agregar a la lista
            phones: [], // Lista de números de teléfono
            message: '',
            response: null,
        };
    },
    methods: {
        // Agregar un número a la lista
        addPhone() {
            if (this.newPhone.trim() !== '' && /^[0-9]{9,15}$/.test(this.newPhone)) {
                this.phones.push(this.newPhone.trim());
                this.newPhone = ''; // Limpiar el campo de entrada
            } else {
                alert('Por favor, ingresa un número de teléfono válido.');
            }
        },
        // Eliminar un número de la lista
        removePhone(index) {
            this.phones.splice(index, 1);
        },
        async sendSms() {
            try {
                // Si hay un número en el campo `newPhone`, agregarlo al array `phones`
                if (this.newPhone.trim() !== '' && /^[0-9]{9,15}$/.test(this.newPhone)) {
                    this.phones.push(this.newPhone.trim());
                    this.newPhone = ''; // Limpiar el campo de entrada
                }

                // Verificar que haya al menos un número en la lista
                if (this.phones.length === 0) {
                    alert('Por favor, agrega al menos un número de teléfono.');
                    return;
                }

                const response = await axios.post('/api/send-sms', {
                    phones: this.phones,
                    message: this.message,
                });
                this.response = response.data.message;
            } catch (error) {
                this.response = 'Error al enviar el SMS.';
            }
        },
    },
};
</script>

<style>

/* Fondo general de la página */
html, body {
    margin: 0; /* Elimina el margen predeterminado */
    padding: 0; /* Elimina el relleno predeterminado */
    background-color: #f8f9fa; /* Fondo uniforme */
    height: 100%; /* Asegura que el fondo cubra toda la página */
    box-sizing: border-box; /* Asegura que el padding y el border no afecten el tamaño total */
}


/* Menú lateral */
.sidebar {
    background-color: white;
    color: #333;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    width: 250px; /* Ancho fijo */
    display: flex;
    flex-direction: column;
    align-items: center;
    position: sticky; /* Menú fijo al hacer scroll */
    top: 20px; /* Espaciado superior */
}

/* Contenedor principal */
.app-container {
    display: flex;
    justify-content: center; /* Centrar horizontalmente */
    align-items: start; /* Centrar verticalmente */
    font-family: 'Roboto', sans-serif;
    gap: 50px; /* Espaciado entre el menú y el contenido principal */
    min-height: 100vh; /* Altura mínima de la ventana */
    border: none; /* Elimina cualquier borde */
    box-shadow: none;
    margin-top: 50px;
}

.sidebar .logo {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 20px;
    color: #007bff; /* Color de acento */
}

.sidebar nav ul {
    list-style: none;
    padding: 0;
    width: 100%;
}

.sidebar nav ul li {
    margin: 10px 0;
}

.sidebar nav ul li a {
    color: #333; /* Texto oscuro */
    text-decoration: none;
    padding: 10px;
    display: block;
    border-radius: 4px;
    transition: background-color 0.3s;
    text-align: center;
}

.sidebar nav ul li a:hover {
    background-color: #007bff;
    color: white; /* Texto blanco para contraste */
}


.container {
    max-width: 800px;
    width: 100%;
    margin: 0; /* Elimina márgenes adicionales */
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

/* Contenedor del formulario */
form {
    margin-top: 30px; /* Espacio superior para separar el formulario del título */
    border: none; 
    box-shadow: none; 
}

/* Espaciado entre los campos del formulario */
form > div {
    margin-bottom: 20px; /* Espacio entre "Mensaje" y "Número de Teléfono" */
}

input,
textarea {
    max-width: 700px;
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

</style>