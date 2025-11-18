/**
 * User Manager Utility
 * 
 * Manages user_id for API requests with fallback to "0" for testing
 */

class UserManager {
  constructor() {
    this.userId = this.getOrCreateUserId();
  }
  
  /**
   * Get or create user ID
   * Falls back to "0" if localStorage is not available
   */
  getOrCreateUserId() {
    try {
      // Try to get existing user_id from localStorage
      let userId = localStorage.getItem('userId');
      
      if (!userId) {
        // Generate a simple user ID
        userId = 'user_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
        localStorage.setItem('userId', userId);
      }
      
      return userId;
    } catch (error) {
      // Fallback to "0" if localStorage is not available (testing mode)
      console.warn('localStorage not available, using fallback user_id: 0');
      return '0';
    }
  }
  
  /**
   * Get current user ID
   */
  getUserId() {
    return this.userId;
  }
  
  /**
   * Reset user ID (generate new one)
   */
  resetUserId() {
    try {
      localStorage.removeItem('userId');
      this.userId = this.getOrCreateUserId();
    } catch (error) {
      // Fallback to "0"
      this.userId = '0';
    }
  }
  
  /**
   * Set user ID manually
   */
  setUserId(userId) {
    try {
      if (userId) {
        localStorage.setItem('userId', userId);
        this.userId = userId;
      }
    } catch (error) {
      console.warn('Failed to set userId, using fallback: 0');
      this.userId = '0';
    }
  }
}

// Export singleton instance
const userManager = new UserManager();

// Make it available globally
if (typeof window !== 'undefined') {
  window.userManager = userManager;
}

export default userManager;

