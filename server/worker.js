require('dotenv').config();
const axios = require('axios');
const { Worker, Queue } = require('bullmq');
const Redis = require('ioredis');

// Redis connection configuration
const connection = new Redis({
  host: process.env.REDIS_HOST || '127.0.0.1',
  port: process.env.REDIS_PORT || 6379,
  password: process.env.REDIS_PASSWORD || undefined,
  maxRetriesPerRequest: null,
});

// Test Redis connection
connection.on('connect', () => {
  console.log('[BullMQ] Redis connected successfully');
});

connection.on('error', (err) => {
  console.error('[BullMQ] Redis connection error:', err);
});

/**
 * Email Queue Worker
 * Processes email notification jobs
 */
const emailWorker = new Worker(
  'emails',
  async (job) => {
    console.log(`[BullMQ] Processing email job ${job.id}:`, job.data);

    const { to, subject, template, data } = job.data;

    try {
      // Send email via Laravel API
      const response = await axios.post(
        `${process.env.API_BASE_URL}/admin/send-email`,
        {
          to,
          subject,
          template,
          data
        },
        {
          headers: {
            'Authorization': `Bearer ${process.env.API_TOKEN}`,
            'Content-Type': 'application/json'
          }
        }
      );

      console.log(`[BullMQ] Email sent successfully to ${to}`);
      return { success: true, result: response.data };

    } catch (error) {
      console.error(`[BullMQ] Email send failed:`, error.message);
      throw new Error(`Failed to send email to ${to}: ${error.message}`);
    }
  },
  {
    connection,
    concurrency: 5, // Process up to 5 emails concurrently
    limiter: {
      max: 10,
      duration: 1000 // Max 10 emails per second
    }
  }
);

/**
 * AI Task Queue Worker
 * Processes AI-related background tasks
 */
const aiWorker = new Worker(
  'ai-tasks',
  async (job) => {
    console.log(`[BullMQ] Processing AI job ${job.id}:`, job.data);

    const { type, payload } = job.data;

    try {
      let result;

      switch (type) {
        case 'generate-content':
          result = await generateContent(payload);
          break;

        case 'analyze-sentiment':
          result = await analyzeSentiment(payload);
          break;

        case 'generate-seo':
          result = await generateSEO(payload);
          break;

        case 'chatbot-response':
          result = await chatbotResponse(payload);
          break;

        default:
          throw new Error(`Unknown AI task type: ${type}`);
      }

      console.log(`[BullMQ] AI task ${type} completed successfully`);
      return { success: true, result };

    } catch (error) {
      console.error(`[BullMQ] AI task failed:`, error.message);
      throw error;
    }
  },
  {
    connection,
    concurrency: 3, // Process up to 3 AI tasks concurrently
    limiter: {
      max: 5,
      duration: 60000 // Max 5 AI tasks per minute (rate limiting)
    }
  }
);

/**
 * Notification Queue Worker
 * Processes push notifications and SMS
 */
const notificationWorker = new Worker(
  'notifications',
  async (job) => {
    console.log(`[BullMQ] Processing notification job ${job.id}:`, job.data);

    const { userId, type, title, message, data } = job.data;

    try {
      // Send notification via Laravel API
      const response = await axios.post(
        `${process.env.API_BASE_URL}/admin/send-notification`,
        {
          user_id: userId,
          type,
          title,
          message,
          data
        },
        {
          headers: {
            'Authorization': `Bearer ${process.env.API_TOKEN}`,
            'Content-Type': 'application/json'
          }
        }
      );

      console.log(`[BullMQ] Notification sent to user ${userId}`);
      return { success: true, result: response.data };

    } catch (error) {
      console.error(`[BullMQ] Notification send failed:`, error.message);
      throw error;
    }
  },
  {
    connection,
    concurrency: 10
  }
);

/**
 * Report Generation Queue Worker
 * Generates complex reports in background
 */
const reportWorker = new Worker(
  'reports',
  async (job) => {
    console.log(`[BullMQ] Processing report job ${job.id}:`, job.data);

    const { reportType, userId, filters, format } = job.data;

    try {
      // Generate report via Laravel API
      const response = await axios.post(
        `${process.env.API_BASE_URL}/admin/generate-report`,
        {
          report_type: reportType,
          user_id: userId,
          filters,
          format
        },
        {
          headers: {
            'Authorization': `Bearer ${process.env.API_TOKEN}`,
            'Content-Type': 'application/json'
          },
          timeout: 300000 // 5 minute timeout for large reports
        }
      );

      console.log(`[BullMQ] Report generated successfully`);
      return { success: true, result: response.data };

    } catch (error) {
      console.error(`[BullMQ] Report generation failed:`, error.message);
      throw error;
    }
  },
  {
    connection,
    concurrency: 2, // Limit concurrent report generation
    limiter: {
      max: 10,
      duration: 60000 // Max 10 reports per minute
    }
  }
);

/**
 * AI Helper Functions
 */

async function generateContent(payload) {
  const { title, category, contentType } = payload;
  
  const response = await axios.post(
    `${process.env.API_BASE_URL}/admin/ai/generate-content`,
    { title, category, content_type: contentType },
    {
      headers: {
        'Authorization': `Bearer ${process.env.API_TOKEN}`,
        'Content-Type': 'application/json'
      }
    }
  );

  return response.data;
}

async function analyzeSentiment(payload) {
  const { text, reviewId } = payload;
  
  const response = await axios.post(
    `${process.env.API_BASE_URL}/admin/ai/analyze-sentiment`,
    { text, review_id: reviewId },
    {
      headers: {
        'Authorization': `Bearer ${process.env.API_TOKEN}`,
        'Content-Type': 'application/json'
      }
    }
  );

  return response.data;
}

async function generateSEO(payload) {
  const { content, title, keywords } = payload;
  
  const response = await axios.post(
    `${process.env.API_BASE_URL}/admin/ai/generate-seo`,
    { content, title, keywords },
    {
      headers: {
        'Authorization': `Bearer ${process.env.API_TOKEN}`,
        'Content-Type': 'application/json'
      }
    }
  );

  return response.data;
}

async function chatbotResponse(payload) {
  const { message, context, sessionId } = payload;
  
  const response = await axios.post(
    `${process.env.API_BASE_URL}/admin/ai/chatbot`,
    { message, context, session_id: sessionId },
    {
      headers: {
        'Authorization': `Bearer ${process.env.API_TOKEN}`,
        'Content-Type': 'application/json'
      }
    }
  );

  return response.data;
}

/**
 * Worker Event Handlers
 */

// Email worker events
emailWorker.on('completed', (job, result) => {
  console.log(`[BullMQ] Email job ${job.id} completed:`, result);
});

emailWorker.on('failed', (job, err) => {
  console.error(`[BullMQ] Email job ${job.id} failed:`, err.message);
});

// AI worker events
aiWorker.on('completed', (job, result) => {
  console.log(`[BullMQ] AI job ${job.id} completed:`, result);
});

aiWorker.on('failed', (job, err) => {
  console.error(`[BullMQ] AI job ${job.id} failed:`, err.message);
});

// Notification worker events
notificationWorker.on('completed', (job, result) => {
  console.log(`[BullMQ] Notification job ${job.id} completed:`, result);
});

notificationWorker.on('failed', (job, err) => {
  console.error(`[BullMQ] Notification job ${job.id} failed:`, err.message);
});

// Report worker events
reportWorker.on('completed', (job, result) => {
  console.log(`[BullMQ] Report job ${job.id} completed:`, result);
});

reportWorker.on('failed', (job, err) => {
  console.error(`[BullMQ] Report job ${job.id} failed:`, err.message);
});

/**
 * Create queues for adding jobs from Node.js
 */
const emailQueue = new Queue('emails', { connection });
const aiQueue = new Queue('ai-tasks', { connection });
const notificationQueue = new Queue('notifications', { connection });
const reportQueue = new Queue('reports', { connection });

// Export queues for external use
module.exports = {
  emailQueue,
  aiQueue,
  notificationQueue,
  reportQueue
};

console.log('[BullMQ] Workers started successfully');
console.log('[BullMQ] Listening on queues: emails, ai-tasks, notifications, reports');

// Graceful shutdown
process.on('SIGTERM', async () => {
  console.log('[BullMQ] SIGTERM received, closing workers...');
  await Promise.all([
    emailWorker.close(),
    aiWorker.close(),
    notificationWorker.close(),
    reportWorker.close()
  ]);
  await connection.quit();
  console.log('[BullMQ] Workers closed');
  process.exit(0);
});

process.on('SIGINT', async () => {
  console.log('[BullMQ] SIGINT received, closing workers...');
  await Promise.all([
    emailWorker.close(),
    aiWorker.close(),
    notificationWorker.close(),
    reportWorker.close()
  ]);
  await connection.quit();
  console.log('[BullMQ] Workers closed');
  process.exit(0);
});
