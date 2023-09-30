<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: String,
    placeholder: String
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        ref="input"
        class="w-full my-2 border-gray-300 text-black bg-slate-200 focus:bg-white focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
        :value="modelValue"
        :placeholder="placeholder"
        @input="$emit('update:modelValue', $event.target.value)"
    >
</template>
