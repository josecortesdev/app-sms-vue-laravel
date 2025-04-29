<template>
    <div>
        <h2>Enviar SMS</h2>
        <form @submit.prevent="sendSms">
            <div>
                <label for="message">Mensaje:</label><br>
                <textarea
                    id="message"
                    v-model="message"
                    placeholder="Escribe tu mensaje aquí"
                ></textarea>
            </div>

            <div>
                <label for="phone">Número de Teléfono:</label>
                <input
                    id="phone"
                    type="text"
                    v-model="newPhone"
                    placeholder="Ejemplo: 1234567890"
                />
                <button class="btn btn-primary mt-3" type="button" @click="addPhone">Agregar Número</button>
            </div>

            <!-- Lista de números agregados -->
            <ul>
                <li v-for="(num, index) in phones" :key="index">
                    {{ num }}
                    <button type="button" @click="removePhone(index)">Eliminar</button>
                </li>
            </ul>

            <button class="btn btn-primary" type="submit">Enviar</button>
        </form>
        <div v-if="response">
            <h3>Resultado:</h3>
            <p>{{ response }}</p>
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

<style scoped>
/* Estilos específicos para el formulario */

textarea,
input {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 4px;
}


</style>