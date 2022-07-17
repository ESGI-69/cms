<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title><?= $pageTitle ?></title>
  <?php if (isset($pageDescription)) : ?>
    <meta name="description" content="<?= $pageDescription ?>">
  <?php endif; ?>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#2C2C2C"/>
  <link rel="stylesheet" href="/css/index.css">
  <link rel="icon" type="image/x-icon" href="assets/favicon.ico">
  <link rel="apple-touch-icon" href="assets/favicon.ico" />
</head>

<body>
  <div class="<?= $this->template ?> <?= $this->view ?>">
    <a href="/" class="logo" aria-label="Image button to the home">
      <svg width="314" height="76" viewBox="0 0 314 76" fill="none" xmlns="http://www.w3.org/2000/svg">
        <g clip-path="url(#clip0_621_2577)">
          <path d="M54.3792 30.7198L40.0642 68.1732H38.5945L29.2766 42.2326L19.6059 68.1732H18.1362L4.58549 30.7787L0.146971 29.9543C-0.0489902 29.1887 -0.0489902 28.2465 0.146971 27.1276C2.73366 27.3043 5.5261 27.3926 8.5243 27.3926C11.209 27.3926 14.0602 27.3239 17.078 27.1865C17.3523 28.1287 17.3523 29.0513 17.078 29.9543L11.6401 30.7787L17.2838 46.826C18.9298 51.5371 20.0076 54.9526 20.5171 57.0726H20.6641C21.8007 53.0289 22.9078 49.7311 23.9856 47.1793L27.5717 37.4921L25.1908 30.7787L20.7229 29.9543C20.5465 29.1887 20.5465 28.2465 20.7229 27.1276C23.3096 27.3043 26.1118 27.3926 29.1296 27.3926C31.8143 27.3926 34.6557 27.3239 37.6539 27.1865C37.9478 28.1287 37.9478 29.0513 37.6539 29.9543L32.2454 30.7787L37.6539 46.826C39.3 51.5371 40.3876 54.9526 40.9166 57.0726H41.0636C42.1806 53.0289 43.278 49.7311 44.3558 47.1793L50.4991 30.5137L45.0024 29.9543C44.8065 29.1887 44.8065 28.2465 45.0024 27.1276C47.5891 27.3043 50.0092 27.3926 52.2628 27.3926C54.2028 27.3926 56.6719 27.3239 59.6701 27.1865C59.9641 28.1287 59.9641 29.0513 59.6701 29.9543L54.3792 30.7198ZM74.2202 38.7876V61.4598L79.9227 62.5198C79.9619 62.7554 80.0011 62.9713 80.0403 63.1676C80.0599 63.3443 80.0697 63.5504 80.0697 63.7859C80.0697 64.0215 80.0599 64.2669 80.0403 64.5221C80.0011 64.7969 79.9619 65.0717 79.9227 65.3465C76.9637 65.2091 73.9263 65.1404 70.8105 65.1404C69.7327 65.1404 68.4296 65.1502 66.9011 65.1698C65.3726 65.1895 63.6187 65.2287 61.6395 65.2876C61.5024 64.8558 61.4338 64.4043 61.4338 63.9332C61.4338 63.5013 61.5024 63.0302 61.6395 62.5198L67.2244 61.7543C67.3224 60.4195 67.391 59.0159 67.4302 57.5437C67.489 56.0519 67.5184 54.4619 67.5184 52.7737V37.7276C67.5184 34.6065 67.44 32.2902 67.2832 30.7787L61.7277 30.0721C61.6297 29.8365 61.5807 29.4439 61.5807 28.8943C61.5807 28.6587 61.5807 28.4232 61.5807 28.1876C61.5807 27.9521 61.6297 27.6871 61.7277 27.3926C64.9219 27.216 68.9685 26.7252 73.8675 25.9204C74.279 26.3915 74.5142 26.8626 74.5729 27.3337C74.3378 28.6489 74.2202 32.4669 74.2202 38.7876ZM63.9029 13.5537C63.8049 13.3182 63.7559 13.0728 63.7559 12.8176C63.7559 12.5428 63.7559 12.2876 63.7559 12.0521C63.7559 10.7958 64.285 9.77503 65.3432 8.98985C66.4014 8.20466 67.7143 7.81207 69.282 7.81207C70.7321 7.81207 71.9177 8.25373 72.8387 9.13707C73.7597 10.0008 74.2202 11.1884 74.2202 12.6998C74.2202 13.9169 73.6911 14.9082 72.6329 15.6737C71.5747 16.4197 70.2226 16.7926 68.5765 16.7926C67.44 16.7926 66.4406 16.508 65.5783 15.9387C64.6965 15.3891 64.138 14.5941 63.9029 13.5537ZM110.316 61.8132L96.0013 44.706L110.757 30.4254L106.083 29.866C105.907 29.12 105.907 28.2072 106.083 27.1276C108.67 27.3043 111.1 27.3926 113.373 27.3926C115.196 27.3926 117.635 27.3239 120.692 27.1865C120.986 28.0306 120.986 28.9237 120.692 29.866L115.137 30.8671L102.644 42.5859L118.017 61.0476L123.514 62.4609C123.71 63.2069 123.71 64.1491 123.514 65.2876C120.555 65.1306 117.596 65.0521 114.637 65.0521C112.619 65.0521 109.63 65.1011 105.672 65.1993C105.398 64.2571 105.398 63.3443 105.672 62.4609L110.316 61.8132ZM95.237 20.2671V61.4598L100.939 62.5198C101.135 63.2658 101.135 64.208 100.939 65.3465C97.9805 65.2091 94.9725 65.1404 91.9155 65.1404C89.7599 65.1404 86.7029 65.1895 82.7445 65.2876C82.4702 64.3847 82.4702 63.4621 82.7445 62.5198L88.3294 61.7543C88.5058 59.1632 88.594 56.1697 88.594 52.7737V12.2876L82.8033 11.581C82.6269 10.8743 82.6269 9.97133 82.8033 8.87207C85.9583 8.63651 89.9853 8.14577 94.8843 7.39985C95.2958 7.87096 95.531 8.34207 95.5898 8.81318C95.3546 10.0302 95.237 13.8482 95.237 20.2671ZM138.27 38.7876V61.4598L143.973 62.5198C144.031 62.7554 144.071 62.9713 144.09 63.1676C144.11 63.3443 144.12 63.5504 144.12 63.7859C144.12 64.0215 144.11 64.2669 144.09 64.5221C144.071 64.7969 144.031 65.0717 143.973 65.3465C141.014 65.2091 137.986 65.1404 134.89 65.1404C133.792 65.1404 132.479 65.1502 130.951 65.1698C129.422 65.1895 127.678 65.2287 125.719 65.2876C125.562 64.8558 125.484 64.4043 125.484 63.9332C125.484 63.5013 125.562 63.0302 125.719 62.5198L131.274 61.7543C131.372 60.4195 131.441 59.0159 131.48 57.5437C131.539 56.0519 131.568 54.4619 131.568 52.7737V37.7276C131.568 34.6065 131.5 32.2902 131.362 30.7787L125.778 30.0721C125.68 29.8365 125.631 29.4439 125.631 28.8943C125.631 28.6587 125.631 28.4232 125.631 28.1876C125.631 27.9521 125.68 27.6871 125.778 27.3926C128.972 27.216 133.018 26.7252 137.917 25.9204C138.329 26.3915 138.564 26.8626 138.623 27.3337C138.388 28.6489 138.27 32.4669 138.27 38.7876ZM127.953 13.5537C127.874 13.3182 127.835 13.0728 127.835 12.8176C127.835 12.5428 127.835 12.2876 127.835 12.0521C127.835 10.7958 128.364 9.77503 129.422 8.98985C130.481 8.20466 131.784 7.81207 133.332 7.81207C134.782 7.81207 135.968 8.25373 136.889 9.13707C137.81 10.0008 138.27 11.1884 138.27 12.6998C138.27 13.9169 137.741 14.9082 136.683 15.6737C135.625 16.4197 134.272 16.7926 132.626 16.7926C131.49 16.7926 130.49 16.508 129.628 15.9387C128.746 15.3891 128.188 14.5941 127.953 13.5537ZM174.395 61.8132L160.051 44.706L174.807 30.4254L170.163 29.866C169.967 29.12 169.967 28.2072 170.163 27.1276C172.749 27.3043 175.17 27.3926 177.423 27.3926C179.246 27.3926 181.685 27.3239 184.742 27.1865C185.036 28.0306 185.036 28.9237 184.742 29.866L179.187 30.8671L166.694 42.5859L182.067 61.0476L187.564 62.4609C187.76 63.2069 187.76 64.1491 187.564 65.2876C184.605 65.1306 181.646 65.0521 178.687 65.0521C176.669 65.0521 173.68 65.1011 169.722 65.1993C169.447 64.2571 169.447 63.3443 169.722 62.4609L174.395 61.8132ZM159.287 20.2671V61.4598L164.989 62.5198C165.185 63.2658 165.185 64.208 164.989 65.3465C162.03 65.2091 159.022 65.1404 155.965 65.1404C153.81 65.1404 150.753 65.1895 146.794 65.2876C146.52 64.3847 146.52 63.4621 146.794 62.5198L152.379 61.7543C152.556 59.1632 152.644 56.1697 152.644 52.7737V12.2876L146.883 11.581C146.687 10.8743 146.687 9.97133 146.883 8.87207C150.018 8.63651 154.035 8.14577 158.934 7.39985C159.365 7.87096 159.6 8.34207 159.64 8.81318C159.404 10.0302 159.287 13.8482 159.287 20.2671ZM202.32 38.7876V61.4598L208.022 62.5198C208.081 62.7554 208.12 62.9713 208.14 63.1676C208.16 63.3443 208.169 63.5504 208.169 63.7859C208.169 64.0215 208.16 64.2669 208.14 64.5221C208.12 64.7969 208.081 65.0717 208.022 65.3465C205.063 65.2091 202.036 65.1404 198.94 65.1404C197.862 65.1404 196.559 65.1502 195.03 65.1698C193.502 65.1895 191.748 65.2287 189.769 65.2876C189.631 64.8558 189.563 64.4043 189.563 63.9332C189.563 63.5013 189.631 63.0302 189.769 62.5198L195.324 61.7543C195.422 60.4195 195.5 59.0159 195.559 57.5437C195.598 56.0519 195.618 54.4619 195.618 52.7737V37.7276C195.618 34.6065 195.549 32.2902 195.412 30.7787L189.827 30.0721C189.729 29.8365 189.68 29.4439 189.68 28.8943C189.68 28.6587 189.68 28.4232 189.68 28.1876C189.68 27.9521 189.729 27.6871 189.827 27.3926C193.022 27.216 197.068 26.7252 201.967 25.9204C202.398 26.3915 202.633 26.8626 202.673 27.3337C202.437 28.6489 202.32 32.4669 202.32 38.7876ZM192.032 13.5537C191.934 13.3182 191.885 13.0728 191.885 12.8176C191.885 12.5428 191.885 12.2876 191.885 12.0521C191.885 10.7958 192.414 9.77503 193.472 8.98985C194.53 8.20466 195.834 7.81207 197.382 7.81207C198.832 7.81207 200.017 8.25373 200.938 9.13707C201.859 10.0008 202.32 11.1884 202.32 12.6998C202.32 13.9169 201.791 14.9082 200.733 15.6737C199.674 16.4197 198.322 16.7926 196.676 16.7926C195.54 16.7926 194.54 16.508 193.678 15.9387C192.816 15.3891 192.267 14.5941 192.032 13.5537Z" fill="white" />
          <path fill-rule="evenodd" clip-rule="evenodd" d="M273.629 14.7639C276.832 15.2483 280.054 15.7721 283.214 16.4987C286.693 17.3056 289.72 19.4402 291.652 22.4484C294.453 25.9099 296.479 29.9341 297.592 34.2483C298.357 39.9349 297.614 45.7229 295.438 51.0309C293.265 57.1654 289.526 62.6235 284.595 66.863C279.664 71.1025 273.711 73.9757 267.328 75.1974C266.885 75.2984 266.433 75.3588 265.979 75.3778C264.71 75.3984 263.441 75.3778 262.172 75.3778C258.414 75.7669 254.619 75.1938 251.143 73.7121C247.667 72.2304 244.623 69.8887 242.298 66.9066C239.52 63.7696 237.63 59.9463 236.823 55.8322C236.016 51.7181 236.32 47.4627 237.706 43.5061C241.093 33.1257 248.34 24.4504 257.944 19.2812C261.987 17.4881 266.161 16.0044 270.428 14.8429C271.476 14.5743 272.57 14.5467 273.629 14.7622V14.7639ZM288.076 9.70731C290.728 11.0753 293.255 12.6748 295.627 14.4874C297.259 15.8992 298.628 17.5739 299.696 19.4512C301.225 21.9915 302.473 24.7139 303.783 27.4174C304.999 30.0643 305.472 32.9928 305.152 35.8886C304.764 44.0505 302.737 52.0503 299.192 59.4093C297.214 63.3907 294.348 66.8624 290.816 69.5551C289.043 70.9069 287.432 72.5403 285.62 73.8714C284.548 74.6195 283.324 75.122 282.036 75.3434C280.322 75.5014 278.599 75.5284 276.88 75.4241C281.572 71.7931 286.083 68.6465 290.19 65.0361C292.341 63.0986 294.099 60.7628 295.366 58.1572C298.925 50.9981 300.948 43.1721 301.306 35.1827C301.623 31.7114 300.64 28.246 298.547 25.4611C297.991 24.7541 297.512 23.9901 297.117 23.1818C295.445 19.7832 292.923 16.8762 289.797 14.7445C286.67 12.6127 283.045 11.3288 279.276 11.0178C275.225 10.8578 271.17 11.176 267.194 11.9659C266.208 12.0862 265.24 12.3902 264.254 12.5499C257.608 13.8643 251.372 16.7482 246.062 20.9621C240.753 25.176 236.525 30.5983 233.728 36.7783C233.164 37.8071 232.579 38.836 231.996 39.8442L231.553 40.0864C231.209 39.126 231.095 38.0978 231.221 37.0851C231.347 36.0724 231.708 35.1036 232.277 34.2569C234.009 31.3919 235.881 28.63 237.774 25.8664C238.942 24.1506 240.372 22.5979 241.461 20.8425C243.82 17.3887 247.06 14.631 250.843 12.8557C258.501 9.12461 266.826 6.96395 275.329 6.50057C279.821 6.279 284.23 7.41089 288.076 9.70903V9.70731ZM231.955 49.37C232.438 51.8914 233.104 54.3716 233.325 56.9136C233.641 60.2055 234.645 63.3938 236.273 66.2713C237.9 69.1488 240.113 71.6511 242.769 73.6155C243.037 73.844 243.289 74.0896 243.539 74.3369L243.916 74.7045L243.776 75.3692H240.614L239.345 74.7045C238.074 74.0297 236.885 73.2108 235.801 72.2638C234.049 70.6481 232.596 68.7351 231.509 66.6129L231.19 65.9705V51.6887C231.19 51.115 231.247 50.55 231.301 49.99L231.353 49.4301L231.955 49.37ZM275.811 0.312079C283.604 -0.797486 291.517 1.07812 298.002 5.51639C298.888 6.06086 299.853 6.54351 301.263 7.33017V7.25116C302.693 8.52218 304.042 9.91343 305.231 11.4249C305.754 12.0913 306.258 12.7578 306.74 13.4225C306.89 14.5369 307.253 15.6121 307.808 16.5897C310.256 21.6334 311.927 27.0197 312.763 32.565C314.501 41.3502 313.036 50.4682 308.634 58.2637C308.411 58.7669 308.211 59.2513 308.01 59.7356C307.022 61.2076 306.117 62.7208 305.15 64.1928C303.136 67.306 300.617 70.061 297.698 72.3445C295.717 73.8767 293.396 74.9077 290.932 75.3503L289.903 75.3091L289.723 74.7045C295.861 70.6042 300.68 64.81 303.598 58.0232C306.629 52.6186 308.191 46.5118 308.128 40.3131C307.828 34.8946 306.944 29.5245 305.491 24.2966C304.331 20.3732 302.395 16.724 299.796 13.5668C297.198 10.4096 293.991 7.80892 290.368 5.92002C288.194 5.05961 285.921 4.47677 283.602 4.18525C276.129 2.67958 268.41 2.92826 261.049 4.91179C260.526 5.01313 260.003 5.11447 259.458 5.1952C259.197 5.1952 258.914 5.15397 258.652 5.09214L258.755 4.66961C264.434 3.17702 270.049 1.31859 275.809 0.312079H275.811ZM267.469 18.5564C264.026 19.1403 260.703 20.4921 257.301 21.3801C254.621 22.187 252.225 23.7399 250.392 25.8578C245.569 31.0258 241.945 37.1977 239.78 43.9321C238.827 47.0664 238.582 50.3739 239.062 53.615C239.542 56.8561 240.737 59.9495 242.558 62.671C244.541 65.8439 247.343 68.4207 250.668 70.1284C253.993 71.8362 257.718 72.6114 261.447 72.372C266.174 72.3531 270.814 71.0878 274.898 68.7032C278.971 66.0031 282.64 62.7361 285.793 59.0005C288.276 56.6008 290.22 53.6996 291.497 50.4896C292.775 47.2795 293.356 43.8341 293.202 40.3818C293.359 34.533 291.535 28.8032 288.027 24.1248C287.368 23.0432 286.463 22.1336 285.385 21.4707C284.306 20.8079 283.087 20.4107 281.826 20.3117C279.511 20.152 277.254 19.2039 274.958 18.881C272.489 18.4212 269.968 18.3125 267.469 18.5581V18.5564ZM286.393 28.7674C288.553 32.1357 289.769 36.0227 289.917 40.0228C289.962 44.6122 288.887 49.143 286.784 53.2209C284.682 57.2987 281.616 60.8 277.854 63.4199C275.078 65.7621 271.764 67.3771 268.211 68.1199C264.658 68.8628 260.976 68.7103 257.496 67.6761C253.609 67.0326 250.081 65.0137 247.554 61.9861C245.026 58.9585 243.667 55.1232 243.722 51.1769C243.307 47.3207 243.93 43.4233 245.527 39.8901C247.124 36.3569 249.637 33.3169 252.805 31.0862C255.513 29.3503 258.317 27.7676 261.202 26.3456C260.315 27.213 259.49 28.1611 258.523 28.9289C254.943 31.5131 252.097 34.9869 250.264 39.0082C248.431 43.0295 247.676 47.4596 248.073 51.8622C248.237 55.4507 249.815 58.8273 252.462 61.2514C255.108 63.6754 258.607 64.9489 262.189 64.7922C262.692 64.7716 263.196 64.7321 263.698 64.6514C269.387 63.9274 274.694 61.3968 278.842 57.4306C281.879 54.9547 284.13 51.6465 285.321 47.91C286.511 44.1735 286.59 40.1705 285.546 36.3901C284.748 33.4413 283.068 30.8077 280.732 28.8428C278.396 26.8779 275.516 25.6757 272.479 25.3975C269.518 25.176 266.538 25.4783 263.558 25.5401C266.628 23.8208 270.088 22.9179 273.605 22.9173C276.077 22.5002 278.616 22.8346 280.895 23.8774C283.175 24.9202 285.09 26.6235 286.393 28.7674ZM277.669 31.4194C279.878 32.9685 281.578 35.1382 282.557 37.6546C283.535 40.1711 283.747 42.9215 283.166 45.5586C282.793 47.7544 281.953 49.8439 280.702 51.6853C279.451 53.5267 277.819 55.0767 275.917 56.23C273.706 57.7976 271.329 59.1166 268.83 60.1633C265.863 61.4785 262.496 61.5609 259.468 60.3923C256.44 59.2238 253.999 56.8997 252.68 53.9302C251.755 51.8421 251.435 49.5361 251.754 47.2745C252.076 43.8958 253.181 40.6391 254.981 37.7639C256.782 34.8887 259.228 32.4745 262.124 30.7135C264.463 29.188 267.221 28.4356 270.01 28.5619C272.798 28.6882 275.477 29.687 277.669 31.4177V31.4194ZM267.52 32.6492C265.416 32.6796 263.345 33.1787 261.457 34.1103C259.57 35.042 257.913 36.3828 256.606 38.0356C254.652 40.5663 253.622 43.6909 253.686 46.8898C253.103 52.1353 256.869 56.8948 262.122 57.4804L263.091 57.5406C266.776 57.4917 270.325 56.1418 273.114 53.7287C275.902 51.3156 277.751 47.9941 278.335 44.3494C278.774 42.1877 278.425 39.9396 277.349 38.0144C276.273 36.0892 274.543 34.615 272.474 33.8601C270.862 33.3362 269.192 32.9326 267.52 32.6492ZM268.227 38.276C272.033 38.3155 273.684 39.8683 274.067 43.9029C274.253 45.3047 274.033 46.7305 273.433 48.0106C272.833 49.2908 271.879 50.3713 270.684 51.1236C269.626 52.0526 268.327 52.663 266.937 52.8845C265.548 53.1061 264.124 52.9297 262.831 52.3758C261.486 51.8503 260.404 50.8119 259.823 49.4884C259.242 48.1649 259.208 46.6645 259.73 45.3165C259.871 44.9523 260.053 44.5693 260.274 44.2464C261.074 42.94 261.976 41.6989 262.971 40.5347C263.58 39.7385 264.384 39.1127 265.304 38.7171C266.224 38.3216 267.231 38.1697 268.227 38.276Z" fill="white" />
        </g>
        <defs>
          <clipPath id="clip0_621_2577">
            <rect width="313.475" height="75.4962" fill="white" />
          </clipPath>
        </defs>
      </svg>
    </a>

    <div class="user-actions">
      <?php if ($isMod) : ?>
        <a class="button button--primary button--big" href="/me">Mon profil</a>
        <a class="button button--primary button--big" href="/logout">Déconnexion</a>
        <a class="button button--primary button--big" href="/dashboard">Admin</a>
      <?php elseif ($isAuth) : ?>
        <a class="button button--primary button--big" href="/me">Mon profil</a>
        <a class="button button--primary button--big" href="/logout">Déconnexion</a>
      <?php else : ?>
        <a class="button button--primary button--big" href="./login">Se connecter</a>
        <a class="button button--primary button--big" href="./register">S'inscrire</a>
      <?php endif; ?>
      <button aria-label="Open sidemenu" href="#" class="button button--primary button--big button-icon openbtn" id="burgerMenu">
        <svg height="18" widht="18" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>
    </div>

    <?php include "Components/sidebarfront.component.php"; ?>

    <main>
      <?php include "View/" . $this->view . ".view.php"; ?>
    </main>

  </div>
  <?php include "Components/footer.component.php"; ?>

</body>

</html>