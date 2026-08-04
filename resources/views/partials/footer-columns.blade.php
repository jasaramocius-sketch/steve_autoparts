@php
    $footerColumns = json_decode(\App\Models\Setting::get('footer_columns', '[]'), true);
    if (!is_array($footerColumns) || empty($footerColumns)) {
        $footerColumns = [
            [
                'type' => 'contact', 'heading' => '', 'span' => 4, 'links' => [],
            ],
            [
                'type' => 'links', 'heading' => 'Quick Links', 'span' => 2, 'links' => [
                    ['label' => 'Home', 'url' => route('home')],
                    ['label' => 'Shop', 'url' => route('shop')],
                    ['label' => 'Categories', 'url' => route('categories.index')],
                    ['label' => 'Brands', 'url' => route('brands')],
                    ['label' => 'About Us', 'url' => route('about')],
                    ['label' => 'Contact Us', 'url' => route('contact')],
                ],
            ],
            [
                'type' => 'links', 'heading' => 'Customer Service', 'span' => 2, 'links' => [
                    ['label' => 'Terms & Conditions', 'url' => route('terms.conditions')],
                    ['label' => 'Privacy Policy', 'url' => route('privacy.policy')],
                    ['label' => 'Return Policy', 'url' => route('return.policy')],
                    ['label' => 'Support Policy', 'url' => route('support.policy')],
                ],
            ],
            [
                'type' => 'newsletter', 'heading' => 'Subscribe to our newsletter', 'span' => 4, 'links' => [],
            ],
        ];
    }
    $footerAllowedSpans = [2, 3, 4, 6, 12];
@endphp

@foreach($footerColumns as $footerCol)
    @php
        $footerType = $footerCol['type'] ?? 'links';
        $footerSpan = in_array((int) ($footerCol['span'] ?? 2), $footerAllowedSpans) ? (int) $footerCol['span'] : 2;
        $footerHeading = $footerCol['heading'] ?? '';
        $footerLinks = $footerCol['links'] ?? [];
        $footerColClass = 'col-lg-' . $footerSpan . ' col-md-3 col-12';
        if ($footerType === 'contact') {
            $footerColClass .= ' left-info';
        } elseif ($footerType === 'links') {
            $footerColClass .= ' footer-link-col';
        }
    @endphp
    <div class="{{ $footerColClass }}">
        @if($footerType === 'contact')
            <a class="header-logo-wrapper" href="{{ route('home') }}">
                {!! imgTag('assets/images/' . (\App\Models\Setting::get('footer_logo') ?? '1730281141Whitepng.png'), 'logo', 'logo mb-3') !!}
            </a>
            <a class="wow-replaced d-block mb-2 text-white" data-wow-delay=".1s" href="tel:{{ \App\Models\Setting::get('header_phone', '+1 (234) 567-8901') }}">
                <i class="fas fa-phone-alt me-2"></i> {{ \App\Models\Setting::get('header_phone', '00 000 000 000') }}
            </a>
            <a class="wow-replaced d-block mb-2 text-white" data-wow-delay=".2s" href="mailto:{{ \App\Models\Setting::get('header_email', 'help@steveautoparts.com') }}">
                <i class="fas fa-envelope me-2"></i> {{ \App\Models\Setting::get('header_email', 'help@steveautoparts.com') }}
            </a>
            <a class="wow-replaced d-block text-white" data-wow-delay=".3s" href="{{ route('contact') }}">
                <i class="fas fa-map-marker-alt me-2"></i> {{ \App\Models\Setting::get('header_address', '3584 Hickory Heights Drive , USA') }}
            </a>
        @elseif($footerType === 'newsletter')
            @if($footerHeading)
                <h6 class="text-white mb-3">{{ $footerHeading }}</h6>
            @endif
            <div class="newslatter-area mb-3">
                <div class="newslatter-form">
                    <form action="javascript:void(0);">
                        @csrf
                        <input class="news-latter-input" type="email" placeholder="Your Email" name="email" required>
                        <button class="newsletter-btn steve-btn steve-btn-hover" type="submit">Subscribe</button>
                    </form>
                </div>
                <div class="social-links mt-3 d-flex">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        @else
            @if($footerHeading)
                <h6 class="text-white mb-3">{{ $footerHeading }}</h6>
            @endif
            @if(!empty($footerLinks))
                <ul class="list-unstyled">
                    @foreach($footerLinks as $footerLink)
                        @php
                            $footerLinkUrl = $footerLink['url'] ?? '#';
                            $footerLinkLabel = $footerLink['label'] ?? '';
                        @endphp
                        <li class="mb-2">
                            <a href="{{ $footerLinkUrl === '#' ? 'javascript:void(0)' : url($footerLinkUrl) }}" class="text-secondary">{{ $footerLinkLabel }}</a>
                        </li>
                    @endforeach
                </ul>
            @endif
        @endif
    </div>
@endforeach
