<template>
    <div class="d-flex">
        <video ref="video" class="w-100 mx-auto"></video>
    </div>
</template>
<script>
import { onMounted, ref, onBeforeUnmount } from 'vue';
import QrScanner from 'qr-scanner';

export default {
    name: 'QrCodeScanner',
    emits: ['decode'],
    setup(_, { emit }) {
        const video = ref(null);
        let qrScanner;

        onMounted(() => {
            qrScanner = new QrScanner(video.value, result => {
                emit('decode', result.data);
            }, { returnDetailedScanResult: true });

            // qrScanner.start().then(() => {
                // console.log("QR scanner started");
            // }).catch((err) => {
                // console.error('Could not start the QR scanner:', err);
            // });
        });

        onBeforeUnmount(() => {
            if (qrScanner) {
                qrScanner.stop();
            }
        });

        return {
            video
        };
    },
};
</script>