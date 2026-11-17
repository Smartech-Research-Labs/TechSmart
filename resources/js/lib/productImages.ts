// Default cover images for OmniviaTech products, keyed by product slug.
// Used by the homepage, products listing and product detail pages when a product
// has no image uploaded in the admin.
import apiDevelopment from '@/../img/services/API Development.webp';
import crmErpDevelopment from '@/../img/services/CRM & ERP Development.webp';
import eCommerceDevelopment from '@/../img/services/E-commerece Development.webp';
import mobileAppDevelopment from '@/../img/services/Mobile App Development.webp';
import mobileApp from '@/../img/services/Mobile App.webp';
import paidAds from '@/../img/services/Paid Ads.webp';
import seoOptimization from '@/../img/services/SEO Optimization.webp';
import techImage from '@/../img/tech-image.webp';
import tech5 from '@/../img/tech5.webp';
import tech7 from '@/../img/tech7.webp';

export const productImageMap: Record<string, string> = {
  'tillpilot': paidAds,
  'coverdesk': crmErpDevelopment,
  'clinicnest': techImage,
  'chamacore': tech5,
  'chatshop': mobileAppDevelopment,
  'etims-bridge': apiDevelopment,
  'fleetledger': tech7,
  'stocksync': eCommerceDevelopment,
  'dukaboard': seoOptimization,
  'schoolpesa': mobileApp,
};
