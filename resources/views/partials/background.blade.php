<style>
  /* Global background design: subtle coffee-inspired gradient + pattern */
  html, body {
    min-height: 100%;
  }
  body {
    /* Warm gradient with soft vignette */
    background: radial-gradient(1200px 600px at 20% 0%, rgba(255,244,235,0.7), rgba(255,255,255,0) 60%),
                radial-gradient(1000px 500px at 80% 10%, rgba(255,232,214,0.6), rgba(255,255,255,0) 55%),
                linear-gradient(180deg, #fff9f4 0%, #f7efe7 40%, #f3ede7 100%);
    background-attachment: fixed, fixed, fixed;
  }
  /* Subtle bean pattern overlay */
  body:before {
    content: "";
    position: fixed;
    inset: 0;
    pointer-events: none;
    opacity: .08;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='120' height='120' viewBox='0 0 120 120'%3E%3Cg fill='none' stroke='%238c6a53' stroke-width='1.2' opacity='0.5'%3E%3Cpath d='M20 32c12-8 24-8 36 0 0 12-8 24-18 30-10-6-18-18-18-30z'/%3E%3Cpath d='M80 92c12-8 24-8 36 0 0 12-8 24-18 30-10-6-18-18-18-30z' transform='translate(-40 -40)'/%3E%3C/g%3E%3C/svg%3E");
    background-size: 200px 200px;
    background-repeat: repeat;
  }
  /* Ensure cards pop over background */
  .card, .panel, .sheet {
    backdrop-filter: saturate(1.1) contrast(1.02);
  }
</style>
