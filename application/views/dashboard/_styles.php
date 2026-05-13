<style>
    /* Tipografi ve Fontlar */
    .typewriter-container { font-family: 'Pirulen', sans-serif; }
    #irsaliye-count { font-family: 'Pirulen', sans-serif; letter-spacing: -2px; }
    
    /* İmleç Efekti */
    .active-cursor::after {
        content: "|";
        margin-left: 5px;
        color: var(--nigtas-blue);
        animation: blink 0.7s infinite;
        font-weight: bold;
    }
    @keyframes blink { 0%, 100% { opacity: 1; } 50% { opacity: 0; } }
</style>