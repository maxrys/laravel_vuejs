<script setup>
    import { ref } from 'vue';

    const messages = ref({
        'ok'     : [],
        'warning': [],
        'error'  : []
    });

    const addMessage = (message, type = 'ok') => {
        messages.value[type].push(message);
    };

    const deleteMessage = (num, type = 'ok') => {
        messages.value[type] = messages.value[type].filter((value, i) => i !== num);
    };

    const deleteMessagesByType = (type = 'ok') => {
        messages.value[type] = [];
    };

    const deleteMessagesAll = () => {
        deleteMessagesByType('ok');
        deleteMessagesByType('warning');
        deleteMessagesByType('error');
    };

    defineExpose({
        addMessage          : addMessage,
        deleteMessage       : deleteMessage,
        deleteMessagesByType: deleteMessagesByType,
        deleteMessagesAll   : deleteMessagesAll
    })
</script>

<template>
    <x-messages data-type="ok" v-if="messages.ok.length">
        <ul>
            <li v-for="(message, num) in messages.ok" :key="num">
                <span v-html="message"></span> [<a href="#" data-type="delete" v-on:click="deleteMessage(num, 'ok')">x</a>]
            </li>
        </ul>
    </x-messages>
    <x-messages data-type="warning" v-if="messages.warning.length">
        <ul>
            <li v-for="(message, num) in messages.warning" :key="num">
                <span v-html="message"></span> [<a href="#" data-type="delete" v-on:click="deleteMessage(num, 'warning')">x</a>]
            </li>
        </ul>
    </x-messages>
    <x-messages data-type="error" v-if="messages.error.length">
        <ul>
            <li v-for="(message, num) in messages.error" :key="num">
                <span v-html="message"></span> [<a href="#" data-type="delete" v-on:click="deleteMessage(num, 'error')">x</a>]
            </li>
        </ul>
    </x-messages>
</template>
