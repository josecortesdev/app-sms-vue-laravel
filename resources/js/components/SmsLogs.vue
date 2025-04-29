<template>
    <div class="sms-logs">
        <h2>Historial de SMS</h2>
        <table>
            <thead>
                <tr>
                    <th>Teléfonos</th>
                    <th>Mensaje</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="log in logs" :key="log.id">
                    <td>{{ log.phones.join(', ') }}</td>
                    <td>{{ log.message }}</td>
                    <td>{{ log.status }}</td>
                    <td>{{ log.created_at }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    data() {
        return {
            logs: [], // Lista de logs de SMS
        };
    },
    mounted() {
        // Obtener los logs desde el backend
        fetch('/api/sms-logs')
            .then((response) => response.json())
            .then((data) => {
                this.logs = data.data; // Asignar los datos al array de logs
            })
            .catch((error) => {
                console.error('Error al cargar el historial:', error);
            });
    },
};
</script>

<style scoped>
.sms-logs {
    max-width: 800px;
    margin: 0 auto;
    background-color: white;
    padding: 20px;
    /* border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); */
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

th {
    background-color: #f4f4f4;
    font-weight: bold;
}

tr:nth-child(even) {
    background-color: #f9f9f9;
}

tr:hover {
    background-color: #f1f1f1;
}
</style>