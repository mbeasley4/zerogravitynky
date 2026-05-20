import { registerBlockType } from '@wordpress/blocks';

import * as heroSection     from '../../blocks/homepage-hero';
import * as serviceCard     from '../../blocks/service-card';
import * as ctaBanner       from '../../blocks/cta-banner';
import * as testimonialCard from '../../blocks/testimonial-card';
import * as membershipTier  from '../../blocks/membership-tier';
import * as marqueeStrip    from '../../blocks/marquee-strip';
import * as pageHero        from '../../blocks/page-hero';
import * as pageHeroShort   from '../../blocks/page-hero-short';
import * as checkoutTrust      from '../../blocks/checkout-trust';
import * as zgColumn           from '../../blocks/zg-column';
import * as zgContactHours          from '../../blocks/zg-contact-hours';
import * as zgFinancing          from '../../blocks/zg-financing';
import * as zgBookAppointment    from '../../blocks/zg-book-appointment';
import * as zgGiftCard           from '../../blocks/zg-gift-card';
import * as zgCategoryProducts   from '../../blocks/zg-category-products';
import * as zgFaq                from '../../blocks/zg-faq';
import * as servicesSection      from '../../blocks/services-section';
import * as aboutTeam      from '../../blocks/about-team';
import * as zgImageSplit    from '../../blocks/zg-image-split';
import * as zgPolicyNotice  from '../../blocks/zg-policy-notice';
import * as zgReviews        from '../../blocks/zg-reviews';
import * as zgSeoCallout     from '../../blocks/zg-seo-callout';
import * as zgIconCards      from '../../blocks/zg-icon-cards';

[ heroSection, serviceCard, ctaBanner, testimonialCard, membershipTier, marqueeStrip, pageHero, pageHeroShort, checkoutTrust, zgFinancing, zgBookAppointment, zgGiftCard, zgCategoryProducts, zgFaq, servicesSection, aboutTeam, zgContactHours, zgImageSplit, zgPolicyNotice, zgReviews, zgSeoCallout, zgIconCards ].forEach(
  ({ metadata, edit, save }) => {
    registerBlockType( metadata, { edit, save } );
  }
);

// zg-column registered separately to pass deprecated migrations
registerBlockType( zgColumn.metadata, {
  edit:       zgColumn.edit,
  save:       zgColumn.save,
  deprecated: zgColumn.deprecated,
} );
