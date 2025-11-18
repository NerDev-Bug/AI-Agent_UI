/**
 * Progress Simulator Utility
 * Simulates realistic progress based on time elapsed
 * Works independently of backend progress tracking
 */

export class ProgressSimulator {
  constructor() {
    this.startTime = null;
    this.currentProgress = 0;
    this.currentStage = 0;
    this.isComplete = false; // Track if backend confirmed completion
    this.stages = [
      { name: "Validating file...", min: 0, max: 5, duration: 5000 },
      { name: "Extracting content...", min: 5, max: 20, duration: 20000 },
      { name: "Validating content...", min: 20, max: 30, duration: 10000 },
      { name: "Analyzing data...", min: 30, max: 55, duration: 55000 }, // ✅ SLOWEST - 25 seconds
      { name: "Evaluating quality...", min: 55, max: 70, duration: 40000 }, // ✅ Slower - 12 seconds
      { name: "Generating graphs...", min: 70, max: 88, duration: 30000 }, // ✅ Slower - 10 seconds
      { name: "Finalizing...", min: 88, max: 99, duration: 10000 }, // Max 99, not 100
    ];
    this.updateInterval = null;
    this.onProgressUpdate = null;
  }

  /**
   * Start progress simulation
   * @param {Function} onUpdate - Callback function(progress, message)
   */
  start(onUpdate) {
    this.startTime = Date.now();
    this.currentProgress = 0;
    this.currentStage = 0;
    this.isComplete = false; // Reset completion flag
    this.onProgressUpdate = onUpdate;

    // Update every 200ms for smooth animation
    this.updateInterval = setInterval(() => {
      this.update();
    }, 200);

    // Initial update
    this.update();
  }

  /**
   * Update progress based on elapsed time
   */
  update() {
    if (!this.startTime || this.isComplete) return; // Don't update if already complete

    const elapsed = Date.now() - this.startTime;
    const totalDuration = this.stages.reduce((sum, stage) => sum + stage.duration, 0);
    const elapsedRatio = Math.min(elapsed / totalDuration, 0.99); // Cap at 99%

    // Find current stage based on elapsed time
    let accumulatedTime = 0;
    let stageIndex = 0;
    
    for (let i = 0; i < this.stages.length; i++) {
      const stage = this.stages[i];
      const stageEndTime = accumulatedTime + stage.duration;
      const stageRatio = stageEndTime / totalDuration;

      if (elapsedRatio <= stageRatio) {
        stageIndex = i;
        break;
      }
      accumulatedTime = stageEndTime;
    }

    const stage = this.stages[stageIndex];
    const stageStartTime = this.stages.slice(0, stageIndex).reduce((sum, s) => sum + s.duration, 0);
    const stageElapsed = elapsed - stageStartTime;
    const stageProgress = Math.min(stageElapsed / stage.duration, 1);

    // Calculate progress within current stage - cap at 99%
    const progressInStage = stage.min + (stage.max - stage.min) * stageProgress;
    this.currentProgress = Math.min(progressInStage, 99); // Max 99%
    this.currentStage = stageIndex;

    // Call update callback
    if (this.onProgressUpdate) {
      this.onProgressUpdate(
        Math.floor(this.currentProgress),
        stage.name
      );
    }
  }

  /**
   * Update progress when backend job completes
   * @param {String} status - Job status from backend
   */
  updateFromBackend(status) {
    // If backend says complete, jump to 100% immediately
    if (status === 'complete') {
      this.isComplete = true; // Mark as complete
      this.currentProgress = 100;
      if (this.onProgressUpdate) {
        this.onProgressUpdate(100, 'Complete!');
      }
      this.stop();
      return;
    }

    // If backend says failed, stop immediately
    if (status === 'failed') {
      this.isComplete = true; // Mark as complete (failed)
      this.currentProgress = 0; // Reset progress on failure
      this.stop();
      return;
    }

    // If still in progress, simulator continues (stays at max 99%)
  }

  /**
   * Stop progress simulation
   */
  stop() {
    if (this.updateInterval) {
      clearInterval(this.updateInterval);
      this.updateInterval = null;
    }
    this.startTime = null;
  }

  /**
   * Reset progress simulator
   */
  reset() {
    this.stop();
    this.currentProgress = 0;
    this.currentStage = 0;
    this.isComplete = false; // Reset completion flag
  }
}

