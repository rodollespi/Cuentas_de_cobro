<div class="modal" id="pdfViewer" tabindex="-1" role="dialog" aria-labelledby="pdfViewerTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pdfViewerTitle">{{ $documento->nombre }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <embed 
                    src="{{ asset('storage/documentos/' . $documento->archivo) }}"
                    type="application/pdf"
                    width="100%"
                    height="80vh">
            </div>
        </div>
    </div>
</div><div class="modal" id="pdfViewer" tabindex="-1" role="dialog" aria-labelledby="pdfViewerTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pdfViewerTitle">{{ $documento->nombre }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <iframe 
                    src="{{ asset('storage/documentos/' . $documento->archivo) }}"
                    style="width:100%; height:80vh; border:none;">
                </iframe>
            </div>
        </div>
    </div>
</div>

<script>
    console.log("URL enviada al visor PDF.js:", "{{ $url }}");

</script>