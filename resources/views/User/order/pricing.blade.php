@extends('layouts.app')

@section('content')
<link href="{{ asset('css/style-pricing.css') }}" rel="stylesheet">
<script src="{{ asset('js/custom.js') }}"></script>

<section class="page-title">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h1>Omnifluencer Pricing Plans</h1>
        <hr class="orn">
        <p class="pg-title">If you are in the market for a computer, there are a number of factors to consider. Will it be used for your home, your office or perhaps even your home office combo? </p>
        <div class="row" align="center">
          <div class="col-12">
            <div class="onoffswitch">
              <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" checked="checked">
              <label class="onoffswitch-label" for="myonoffswitch">
                <span class="onoffswitch-inner" data-id="1"></span>
                <span class="onoffswitch-switch"></span>
              </label>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="comparison">
  <table>
    <thead>
      <tr>
        <th class="tl">
        </th>
        <th class="qbse compare-heading">
          FREE
        </th>
        <th class="qbse compare-heading">
          PRO
        </th>
        <th class="qbse compare-heading">
          PREMIUM
        </th>
      </tr>
      <tr>
        <th class="price-info">
          <div class="price-now features"><span>Features</span></div>
        </th>
        <th class="price-info">
          <div class="price-now"><span>IDR 0<span class="price-small">,-</span></span></div>
        </th>
        <th class="price-info">
          <div class="price-now"><span class="nprice price_pro">IDR 197</span><span class="price-small">000,-</span></div>
        </th>
        <th class="price-info">
          <div class="price-now"><span class="nprice price_premium">IDR 297</span><span class="price-small">000,-</span></div>
        </th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td></td>
        <td colspan="3">Show History</td>
      </tr>
      <tr class="compare-row">
        <td>Show History</td>
        <td><span class="tickblue">5</span></td>
        <td><span class="tickblue">25</span></td>
        <td><span class="tickblue">Unlimited</span></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="3">Save Profile</td>
      </tr>
      <tr>
        <td>Save Profile</td>
        <td><span class="cross">&#10060;</span></td>
        <td><span class="tickblue">25</span></td>
        <td><span class="tickblue">Unlimited</span></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="3">Compare</td>
      </tr>
      <tr class="compare-row">
        <td>Compare</td>
        <td><span class="cross">&#10060;</span></td>
        <td><span class="tickblue">Yes - 2</span></td>
        <td><span class="tickblue">Yes - 4</span></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="3">Compare From History</td>
      </tr>
      <tr>
        <td>Compare From History</td>
        <td><span class="cross">&#10060;</span></td>
        <td><span class="tickblue">Yes - 2</span></td>
        <td><span class="tickblue">Yes - 4</span></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="3">Grouping</td>
      </tr>
      <tr class="compare-row">
        <td>Grouping</td>
        <td><span class="cross">&#10060;</span></td>
        <td><span class="tickblue">&check;</span></td>
        <td><span class="tickblue">&check;</span></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="3">Bulk Group</td>
      </tr>
      <tr>
        <td>Bulk Group</td>
        <td><span class="cross">&#10060;</span></td>
        <td><span class="tickblue">&check;</span></td>
        <td><span class="tickblue">&check;</span></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="3">Bulk Delete</td>
      </tr>
      <tr class="compare-row">
        <td>Bulk Delete</td>
        <td><span class="cross">&#10060;</span></td>
        <td><span class="tickblue">&check;</span></td>
        <td><span class="tickblue">&check;</span></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="3">Save & Send Influencers Report .PDF</td>
      </tr>
      <tr>
        <td>Save & Send Influencers Report .PDF</td>
        <td><span class="cross">&#10060;</span></td>
        <td><span class="tickblue">&check;</span></td>
        <td><span class="tickblue">&check;</span></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="3">Save & Send Influencers List .XLSX</td>
      </tr>
      <tr class="compare-row">
        <td>Save & Send Influencers List .XLSX</td>
        <td><span class="cross">&#10060;</span></td>
        <td><span class="cross">&#10060;</span></td>
        <td><span class="tickblue">&check;</span></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="3">Bulk Save .PDF</td>
      </tr>
      <tr>
        <td>Bulk Save .PDF</td>
        <td><span class="cross">&#10060;</span></td>
        <td><span class="cross">&#10060;</span></td>
        <td><span class="tickblue">&check;</span></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="3">Bulk Save .XLSX</td>
      </tr>
      <tr class="compare-row">
        <td>Bulk Save .XLSX</td>
        <td><span class="cross">&#10060;</span></td>
        <td><span class="cross">&#10060;</span></td>
        <td><span class="tickblue">&check;</span></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="3">Buy Now</td>
      </tr>
      <tr>
        <td></td>
        <td>
          <div>
            <a href="{{url('register')}}">
              <button class="btn btn-primary select-price btn-primary-prc" data-package="1">
                SELECT
              </button>
            </a>
          </div>
        </td>
        <td>
          <div class="monthly-button">
            <a href="{{url('checkout/1')}}">
              <button class="btn btn-primary select-price btn-primary-prc" data-package="1">
                SELECT
              </button>
            </a>
          </div>
          <div class="yearly-button">
            <a href="{{url('checkout/2')}}">
              <button class="btn btn-primary select-price btn-primary-prc" data-package="1">
                SELECT
              </button>
            </a>
          </div>
        </td>
        <td>
          <div class="monthly-button">
            <a href="{{url('checkout/3')}}">
              <button class="btn btn-primary select-price btn-primary-prc" data-package="1">
                SELECT
              </button>
            </a>
          </div>
          <div class="yearly-button">
            <a href="{{url('checkout/4')}}">
              <button class="btn btn-primary select-price btn-primary-prc" data-package="1">
                SELECT
              </button>
            </a>
          </div>
        </td>
      </tr>
    </tbody>
  </table>
</div>
@endsection
