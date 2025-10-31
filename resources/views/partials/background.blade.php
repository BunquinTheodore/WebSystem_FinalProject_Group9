<style>
  /* Global background design: subtle coffee-inspired gradient + pattern */
  html, body {
    min-height: 100%;
  }
  body {
    background: #ffffff;
    background-attachment: scroll;
  }
  /* Remove decorative overlay to ensure pure white background */
  body:before { display: none; }
  /* Ensure cards pop over background */
  .card, .panel, .sheet {
    backdrop-filter: saturate(1.1) contrast(1.02);
  }
</style>
